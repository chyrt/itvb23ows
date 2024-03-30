pipeline {
    agent any
    stages {
        stage('Docker compose up') {
            steps {
                script {
                    sh 'echo "Building..."'
                    sh 'docker compose up --build -d'
                }
            }
        }
    }
    post {
        always {
            sh 'docker compose down'
        }
    }
}