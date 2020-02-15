node {
	stage("Setup") {
		checkout scm
	}

    stage("Composer Install") {
        sh 'composer install'
    }

    stage("Unit Tests") {
        sh 'vendor/bin/phpunit'
    }

    switch (env.BRANCH_NAME) {
        case "master":
            stage("Deploy Production") {
                echo"Deploy"
            }
            break
        default:
            break
    }

	stage('cleanup') {
	    deleteDir()
	}
}
