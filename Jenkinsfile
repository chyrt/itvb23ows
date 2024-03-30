pipeline {
    agent any
    stages {
        stage('SQ Analysis') {
                steps {
                    script { scannerHome = tool 'SonarQubeScanner' }
                    withSonarQubeEnv('owsSQ') {
                        sh "${scannerHome}/bin/sonar-scanner -Dsonar.projectKey=owsSQ"
                    }
                }
            }
        stage('Docker compose up --build -d') {
            steps {
                script {
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