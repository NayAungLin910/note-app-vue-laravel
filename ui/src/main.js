import { createApp, h } from 'vue'
import App from './App.vue'
import router from './router';
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import { cusaxios } from './config';

const app = createApp({
    data(){
        return{
            user:null,
            ColorLabel:{
                color: [],
                label: [],
            },
            current_page:"",
        }
    },  
    created(){
        // for Color and Label 
        cusaxios.get(`/colorlabel`)
            .then(res=>{
                this.ColorLabel = res.data.data;    
            });

        // for auth
        const data = localStorage.getItem('auth');
        if(data == 'null'){
            this.user = null;
        }else{
            this.user = JSON.parse(data).user;
        }
    },
    render: () => h(App),
});

app.use(Toast);
app.use(router).mount('#app');
