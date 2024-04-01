pipeline {
    agent any

    stages {
        stage('Checkout Code') {
            steps {
                echo 'Uitchecken van de broncode...'
                checkout scm
            }
        }
        stage('SQ Analysis') {
            steps {
                script {
                    SCANNER_HOME = tool 'SonarQubeScanner'
                }
                withSonarQubeEnv('owsSQ') {
                    sh "${SCANNER_HOME}/bin/sonar-scanner -Dsonar.projectKey=owsSQ"
                }
            }
        }
        stage('Build') {
            steps {
                echo 'Building...'
                sh 'docker compose up --build -d'
            }
        }
        stage('Unit Tests') {
            steps {
                echo 'Uitvoeren van unit tests...'
                sh 'docker compose run --rm web vendor/bin/phpunit tests'
            }
        }
    }

    post {
        always {
            echo 'Opruimen...'
            sh 'docker compose down'
        }
        success {
            echo 'Pipeline succesvol voltooid!'
        }
        failure {
            echo 'Pipeline mislukt. Bekijk de logs voor meer details.'
        }
    }
}