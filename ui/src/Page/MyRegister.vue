<template>
    <MyMaster>
        <div class="row mb-4">
            <div class="col-md-6 offset-3">
                <div class="card">
                    <div class="card-header bg-dark">
                        <h3 class="text-white">Register</h3>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="register" class="text-white">
                            <div class="form-group">
                                <label for="">Enter name</label>
                                <input :class="{'border-danger':error.name}" type="text" v-model="name" class="form-control border" placeholder="Name">
                                <small class="text text-danger" v-if="error.name">{{ error.name[0] }}</small>
                            </div>
                            <div class="form-group">
                                <label for="">Enter email</label>
                                <input type="text" :class="{'border-danger':error.email}" v-model="email" class="form-control border" placeholder="Email">
                                <small class="text text-danger" v-if="error.email">{{ error.email[0] }}</small>
                            </div>
                            <div class="form-group">
                                <label for="">Enter password</label>
                                <input type="password" :class="{'border-danger':error.email}" v-model="password" class="form-control border" placeholder="*****">
                                <small class="text text-danger" v-if="error.password">{{ error.password[0] }}</small>
                            </div>                                
                            <div class="form-group">
                                <label for="">Choose Image</label>
                                <!-- <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                </div> -->
                                <div class="custom-file">
                                    <input type="file" :class="{'border-danger':error.image}" @change="chooseImage" class="custom-file-input border" id="inputGroupFile01"
                                    aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label" for="inputGroupFile01">Image</label>
                                </div>
                                <small class="text text-danger" v-if="error.image">{{ error.image[0] }}</small>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                Register
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
import MyMaster from './Layout/MyMaster.vue';
import { cusaxios } from '@/config';
export default {
    name: "MyRegister",
    components: { MyMaster },
    data(){
        return{
            name: "",
            email: "",
            password: "",
            image: "",
            error: {},
            loading: false,
        }
    },
    methods: {
        chooseImage(e){
            this.image = e.target.files[0];

        },
        async register(){
            this.loading = true;
            const frmData = new FormData();
            frmData.append("name", this.name);
            frmData.append("email", this.email);
            frmData.append("password", this.password);
            frmData.append("image", this.image);

            const res = await cusaxios.post(`/register`, frmData);
            const {data, success} = res.data;
            this.loading = false;
            if(success == false){
                this.error = data; 
            }else{
                this.$root.user = data.user;
                localStorage.setItem('auth', JSON.stringify(data));
                this.$router.push({
                    name:"index",
                    params:{
                        message: JSON.stringify({
                            type:"s",
                            message:`Welcome ${data.user.name} !`,
                        })
                    }
                });
            }
        },
    }
}
</script>