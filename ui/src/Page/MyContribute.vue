<template>
    <MyMaster :message="message">
        <div class="row">
            <MySideBar :key="componentKey"/>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-dark">
                        <h2 class="text-white">Contribute</h2>
                    </div>
                    <div class="card-body">
                        <form class="text-white">
                            <div class="form-group">
                                <label for="">Enter Email</label>
                                <input 
                                  v-model.lazy="email"
                                  type="text" 
                                  class="form-control" 
                                  required 
                                  placeholder="enter email"
                                >
                            </div>
                        </form>

                        <!--When email is found-->
                        <div class="card text-white" v-show="user.name">
                            <div class="card-header bg-primary">
                                <h2>{{ user.name }}</h2>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img 
                                         :src="`${image_url}/${user.image}`" 
                                         alt=""
                                         style="width:70%"
                                         />
                                    </div>
                                    <div class="col-md-8">
                                        <button class="btn btn-primary" @click="contribute">Contribute</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-danger" v-show="user=='not_user'">User Not Found!</div>
                    </div>
                </div>
            </div>
        </div>
    </MyMaster>
</template>
<script>
import MyMaster from './Layout/MyMaster.vue';
import MySideBar from './Layout/MySideBar.vue';
import { cusaxios, image_url } from '@/config';
import { useToast } from 'vue-toastification';
export default {
    name: "MyContribute",
    components: { MyMaster, MySideBar },
    props:{message: Object},
    data(){
        return{
            email: "",
            user: false,
            image_url,
            componentKey: 0,
        }
    },
    created(){
        console.log(this.$attrs);
    },
    methods: {
        forceRerender() {
            this.componentKey += 1;
        },
        async contribute(){
            const contributed_id = this.user.id;
            const slug = this.$attrs.slug;
            const res =  await cusaxios.post('/contribute', {
                contributed_id,
                slug,
            });
            if(res.data.success == true){
                const toast = useToast();
                toast.success('Contributed Successfully !', {
                    timeout: 2000,
                });
                this.forceRerender();
            }
        }
    },
    watch: {
        async email(n){
            const res = await cusaxios.get("/find/user/"+n)
            const { data } = res.data;
            if(data == 'not_user'){
                this.user = 'not_user';
            }else{
                this.user = data;
            }
        }
    }
};
</script>