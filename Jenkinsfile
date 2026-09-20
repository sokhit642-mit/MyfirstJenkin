pipeline {
    agent any

    stages {
        stage('Checkout Code') {
            steps {
                checkout scm
            }
        }
        stage('Build') {
            steps {
                sh 'echo "Building the project"'
                //Add your build commands here
            }
        }
        stage('Push Image') {
            steps {
                sh 'echo "Push Image to Registry"'
                //Add your etst commands here
            }
        }
        stage('Deploy') {
            steps {
                sh 'echo "Deploying the project"'
                //Add your deploy commands here
            }
        }
    }
}