<template>
    <MyMaster>
        <div class="row mb-4">
            <div class="col-md-6 offset-3">
                <div class="card">
                    <div class="card-header bg-dark">
                        <h3 class="text-white">Login</h3>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="login" class="text-white">
                            <div class="form-group">
                                <label for="form-label" >Enter Email</label>
                                <input :class="{'border-danger':error.email}" type="text" v-model="email" class="form-control border" placeholder="email...">
                                <small class="text text-danger" v-if="error.email">{{error.email[0]}}</small>
                            </div>
                            <div class="form-group">
                                <label for="">Enter Password</label>
                                <input :class="{'border-danger':error.password}" type="password" v-model="password" class="form-control border" placeholder="****">
                                <small class="text text-danger" v-if="error.password">{{error.password[0]}}</small>
                            </div>
                            <button type="submit" class="btn btn-primary" :disabled="loading">
                                Login
                                 <span v-show="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </MyMaster>
</template>
<script>
import MyMaster from "./Layout/MyMaster.vue";
import { cusaxios } from "@/config";
export default{
    name: 'MyLogin',
    components: {MyMaster},
    data(){
        return{
            email:"",
            password:"",
            loading:false,
            error:{}
        }
    },
    methods:{
        async login(){
            this.loading = true;
            const res = await cusaxios.post(`/login`, {
                email: this.email,
                password: this.password,
            });
            const { data, success } = res.data;
            this.loading = false;
            if(data == 'wrong_email' && success == false){
                this.error = {
                    email:[
                        'Wrong Email!',
                    ],
                }
            }else if(data == 'wrong_password' && success == false){
                this.error = {
                    password:[
                        'Wrong Password!',
                    ],
                }
            }else if(success == false){
                this.error = data;
            }else{
                this.$root.user = data.user;
                // store to local
                localStorage.setItem('auth', JSON.stringify(data));
                // push
                this.$router.push({
                    name:"index",
                    params:{
                        message: JSON.stringify({
                            type: 's',
                            message:`Welcome ${data.user.name}`, 
                        }),
                    }
                });  
            }
        },
    }
}
</script>