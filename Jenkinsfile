pipeline {
    agent any

    stages {
        stage('Initialisatie') {
            steps {
                echo 'Voorbereidingen en initialisatie...'
            }
        }
        stage('Checkout Code') {
            steps {
                echo 'Uitchecken van de broncode...'
                checkout scm
            }
        }
        stage('Build') {
            steps {
                echo 'Bouwen van de applicatie...'
                // sh 'mvn clean install'
            }
        }
        stage('Unit Tests') {
            steps {
                echo 'Uitvoeren van unit tests...'
                // sh 'mvn test'
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
        stage('Deployment / Test Environment Setup') {
            steps {
                echo 'Opzetten van de testomgeving met Docker...'
                sh 'docker compose up --build -d'
            }
        }
        stage('Acceptatietests') {
            steps {
                echo 'Uitvoeren van acceptatietests...'
            }
        }
        stage('Deployment naar Productie') {
            steps {
                echo 'Deployment naar productieomgeving...'
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