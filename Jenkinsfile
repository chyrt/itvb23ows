pipeline {
    agent any

    stages {
        stage('SCM') {
            steps {
                checkout scm
            }
        }

        stage('Test') {
            agent {
                docker {
                        image 'composer:lts'
                    }
                }
            steps {
                sh 'composer install'
                sh 'php --version'
            }
        }

        stage('Deploy') {
            steps {
                // Voeg stappen toe voor deployment
                // Bijvoorbeeld, Docker containers starten
                script {
                    sh 'docker compose up -d'
                }
            }
        }
    }

    post {
        always {
            // Opruimen na de pipeline is voltooid
            script {
                sh 'docker compose down'
            }
        }
    }
}
