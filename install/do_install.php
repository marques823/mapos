<?php

ini_set('max_execution_time', 300); //300 seconds

$settings_file = __DIR__ . DIRECTORY_SEPARATOR . 'settings.json';

if (! file_exists($settings_file)) {
    exit('Arquivo de configuração não encontrado!');
} else {
    $contents = file_get_contents($settings_file);
    $settings = json_decode($contents, true);
}

if (! empty($_POST)) {
    $host = $_POST['host'];
    $dbuser = $_POST['dbuser'];
    $dbpassword = $_POST['dbpassword'];
    $dbname = $_POST['dbname'];

    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $login_password = $_POST['password'] ? $_POST['password'] : '';
    $base_url = $_POST['base_url'];

    //check required fields
    if (! ($host && $dbuser && $dbname && $full_name && $email && $login_password && $base_url)) {
        echo json_encode(['success' => false, 'message' => 'Por favor insira todos os campos.']);
        exit();
    }

    //check for valid email
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        echo json_encode(['success' => false, 'message' => 'Por favor insira um email válido.']);
        exit();
    }

    //check for valid database connection
    try {
        $mysqli = @new mysqli($host, $dbuser, $dbpassword, $dbname);

        if (mysqli_connect_errno()) {
            echo json_encode(['success' => false, 'message' => $mysqli->connect_error]);
            exit();
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        exit();
    }

    //all input seems to be ok. check required fiels
    if (! is_file($settings['database_file'])) {
        echo json_encode(['success' => false, 'message' => 'O arquivo ../banco.sql não foi encontrado na pasta de instalação!']);
        exit();
    }

    /*
     * check the db config file
     * if db already configured, we'll assume that the installation has completed
     */
    $env_path = '..' . DIRECTORY_SEPARATOR . '.env';
    $is_installed = file_exists($env_path) && strpos(file_get_contents($env_path), 'APP_ENVIRONMENT="pre_installation"') === false;

    if ($is_installed) {
        echo json_encode(['success' => false, 'message' => 'Parece que este aplicativo já está instalado! Você não pode reinstalá-lo novamente.']);
        exit();
    }

    //start installation
    $sql = file_get_contents($settings['database_file']);

    //set admin information to database
    $now = date('Y-m-d H:i:s');
    $sql = str_replace('admin_name', $full_name, $sql);
    $sql = str_replace('admin_email', $email, $sql);
    $sql = str_replace('admin_password', password_hash($login_password, PASSWORD_DEFAULT), $sql);
    $sql = str_replace('admin_created_at', $now, $sql);

    //create tables in datbase
    $mysqli->multi_query($sql);
    do {
    } while (mysqli_more_results($mysqli) && mysqli_next_result($mysqli));
    $mysqli->close();
    // database created

    $env_example_path = '..' . DIRECTORY_SEPARATOR . '.env.example';
    $env_content = file_get_contents($env_example_path);

    // Se o .env atual existe, vamos tentar preservar as variáveis de Docker (NGINX_PORT, etc)
    if (file_exists($env_path)) {
        $current_env = file_get_contents($env_path);
        // Regex simples para capturar blocos de Docker se existirem
        if (preg_match('/# --- DOCKER CONFIGURATION ---.*?(?=# ---)/s', $current_env, $matches)) {
            $env_content = preg_replace('/# --- DOCKER CONFIGURATION ---.*?(?=# ---)/s', $matches[0], $env_content);
        }
    }

    // set the database config file
    $env_content = str_replace('mysql', $host, $env_content); // HOST
    $env_content = str_replace('mapos', $dbuser, $env_content); // USER (cuidado aqui, pode trocar mais de uma ocorrencia)
    // Para ser mais preciso com o replace do .env.example que unificamos:
    $env_content = str_replace('DB_HOSTNAME=mysql', "DB_HOSTNAME=$host", $env_content);
    $env_content = str_replace('DB_USERNAME=mapos', "DB_USERNAME=$dbuser", $env_content);
    $env_content = str_replace('DB_PASSWORD=mapos', "DB_PASSWORD=$dbpassword", $env_content);
    $env_content = str_replace('DB_DATABASE=mapos', "DB_DATABASE=$dbname", $env_content);

    // set random keys
    $encryption_key = substr(md5(rand()), 0, 15);
    $env_content = str_replace('42a77a02eeb3c69', $encryption_key, $env_content);
    $env_content = str_replace('http://localhost:8000', $base_url, $env_content);
    $env_content = str_replace('boKehm6L8e4hhsBDz2ub49ZJN6//HAx6CCaASNKrRhU=', base64_encode(openssl_random_pseudo_bytes(32)), $env_content);

    // set the environment = production
    $env_content = str_replace('pre_installation', 'production', $env_content);

    if (file_put_contents($env_path, $env_content)) {
        echo json_encode(['success' => true, 'message' => 'Instalação bem sucedida.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao criar arquivo env.']);
    }

    exit();
}
