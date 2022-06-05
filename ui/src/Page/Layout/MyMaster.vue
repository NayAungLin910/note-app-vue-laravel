<template>
    <div>
        <!-- Header -->
    <div class="container-fluid" id="header">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <router-link to="/" class="navbar-brand text-white">MMC-Note</router-link>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent" v-if="$root.user !== null">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <router-link to="/" class="nav-link" v-if="this.$root.current_page !== 'index'">Home</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/note/create" class="nav-link" v-if="this.$root.current_page !== 'create-note'">Create Note</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/label/create" class="nav-link" v-if="this.$root.current_page !== 'create-label'">Create Label</router-link>
                        </li>
                    </ul>
                    <div class="form-inline mr-5">
                        <router-link class="text-reset me-3" to="/profile" v-if="this.$root.current_page !== 'profile'">
                            <img
                                :src="`${image_url}/${$root.user.image}`"
                                class="image-fluid rounded-circle"
                                alt="your profile"
                                height="40"
                            />
                        </router-link>
                    </div>
                </div>
            </div>
        </nav>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6 text-white">
                    <h1>Welcome From MM-Coder Note</h1>
                    <p>
                        This is just a small individual student project developed to for the user to create account, 
                        login and create notes, edit notes and even contribute it to another user. Please try to use
                        it as much as possible since the task of this web app is very simple. 
                    </p>
                    <div v-if="!$root.user">
                        <router-link to="/register" class="btn btn-outline-primary m-2">Register</router-link>
                        <router-link to="/login" class="btn btn-outline-primary">Login</router-link>
                    </div>
                    <button v-else class="btn btn-danger" @click="logout">Logout</button>
                </div>
                <div class="col-md-6 text-center">
                    <img class=""
                        src="https://wp.xpeedstudio.com/seocify/home-fifteen/wp-content/uploads/sites/27/2020/03/home17-banner-image-min.png"
                        alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- End Header -->
    <div class="container mt-5">
        <slot />
    </div>
    </div>
</template>
<script>
import { useToast } from 'vue-toastification';
import { image_url } from '@/config';
export default {
    name: "MyMaster",
    props: {
        message:String,
    },
    data(){
        return{
            image_url,
        }
    },
    created(){
        if(this.message){
            const toast = useToast();
            switch(JSON.parse(this.message).type){
                case 's':
                    toast.success(JSON.parse(this.message).message, {
                        timeout: 2000,
                    })
                    break;
                case 'e':
                    toast.error(JSON.parse(this.message).message, {
                        timeout: 2000,
                    })
                    break;
                case 'i':
                    toast.info(JSON.parse(this.message).message, {
                        timeout: 2000,
                    })
                    break;
            }
        }
    },
    methods: {
        logout(){
            this.$root.user = null;
            localStorage.setItem('auth', 'null');
            this.$router.push({
                name:"login",
                params:{
                    message: JSON.stringify({
                        type:"e",
                        message:`Please login again !`,
                    })
                }
            });
        },
    }
}
</script>