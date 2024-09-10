pipeline {
    agent any

    environment {
        PHP_VERSION = '8.1' // Adjust PHP version according to your project
    }

    stages {
        stage('Fetch the Source code') {
            steps {
                // Clone the repository from GitHub
                git branch: 'main', url: 'https://github.com/MohamedAdelEid/Hyper-Market.git'
            }
        }

    // ---------------------- Without Docker -------------------------

        stage('Install PHP and Composer') {
            steps {
                // Install PHP and Composer on Linux
                sh '''
                    sudo apt update
                    sudo apt install -y software-properties-common
                    sudo add-apt-repository ppa:ondrej/php
                    sudo apt update
                    sudo apt install -y php${PHP_VERSION} php${PHP_VERSION}-cli php${PHP_VERSION}-xml php${PHP_VERSION}-mbstring unzip curl
                    curl -sS https://getcomposer.org/installer | php
                    sudo mv composer.phar /usr/local/bin/composer
                    composer --version
                '''
            }
        }

        stage('Install Dependencies') {
            steps {
                // Install project dependencies using Composer
                sh 'composer install'
            }
        }

        stage('Environment Setup') {
            steps {
                // Copy or set up the .env file, and generate the Laravel application key --> Shell script
                sh '''
                    if [ ! -f .env ]; then
                        cp .env.example .env
                    fi
                    php artisan key:generate
                '''
            }
        }

        stage('Test Code') {
            steps {
                // Run Laravel’s unit and feature tests
                sh 'php artisan test'
            }
        }

        /*If Mohamed {Adel, Abdo} using npm package
        stage('Build') {
            steps {
                sh '''
                    if [ -f package.json ]; then
                        npm install
                        npm run prod
                    fi
                '''
            }
        } */

        // --------------------- With Docker -------------------------
        /*{
            Waiting to Dockerize your Laravel app
        }*/

    }  // End of all Stages



    post {
        always {
            // Notify the Result of my pipeline
            echo 'Pipeline completed'
        }
        success {
            echo 'Build and tests were successful'
        }
        failure {
            echo 'Build or tests failed'
        }
    }
}

