pipeline {
    agent any

    environment {
        // One place for the image name, so build/push/deploy can't drift apart.
        // The part before the slash must be your Docker Hub username.
        IMAGE = 'ksk6898/cc-usea-app-html'
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
                                                  usernameVariable: 'ksk6699',
                                                  passwordVariable: 'KsKDockEr#2027')]) {
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
                        ssh -o StrictHostKeyChecking=no ubuntu@3.107.167.19 "
                            sudo docker rm -f cc-usea-app-html || true
                            sudo docker run -d --name cc-usea-app-html -p 9090:80 $IMAGE:$BUILD_NUMBER
                        "
                    '''
                }
            }
        }
    }
}