pipeline {
    agent any

    stages {
        stage('SCM') {
            steps {
                checkout scm
            }
        }

        stage('Test') {
            steps {
                // Voer uw testscripts uit (indien aanwezig)
                // Voorbeeld: sh 'docker-compose run webapp phpunit'
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
