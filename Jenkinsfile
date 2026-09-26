pipeline {
    agent any

    environment {
        // One place for the image name, so build/push/deploy can't drift apart.
        IMAGE = 'ksk6699/homework-app'
    }

    stages {
        stage('Checkout Code') {
            steps {
                checkout scm
            }
        }

        stage('Build') {
            steps {
                sh 'echo "Building the project..."'
                sh 'docker build -t $IMAGE:$BUILD_NUMBER .'
            }
        }

        stage('Push Image') {
            steps {
                sh 'echo "Push image to registry..."'
                withCredentials([usernamePassword(credentialsId: 'docker-hub-id',
                                                  usernameVariable: 'DOCKER_USERNAME',
                                                  passwordVariable: 'DOCKER_PASSWORD')]) {
                    sh 'echo $DOCKER_PASSWORD | docker login -u $DOCKER_USERNAME --password-stdin'
                    sh 'docker push $IMAGE:$BUILD_NUMBER'
                    sh 'docker logout'
                }
            }
        }

        stage('Deploy') {
            steps {
                sh 'echo "Deploying the project..."'
                // 'smm-ssh' = Jenkins credential (SSH Username with private key)
                sshagent(credentials: ['smm-ssh']) {
                    sh '''
                        ssh -o StrictHostKeyChecking=no ubuntu@13.211.148.233 "
                            sudo docker rm -f homework-app || true
                            sudo docker run -d --name homework-app -p 9099:80 $IMAGE:$BUILD_NUMBER
                        "
                    '''
                }
            }
        }
    }
}