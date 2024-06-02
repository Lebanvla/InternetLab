import "/opt/lampp/htdocs/InternetLab/Second_Semester/Lab_3/Frontend/bootsrap/css/bootstrap.min.css"
import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(router)

app.mount('#app')
