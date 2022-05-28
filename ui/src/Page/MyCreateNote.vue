<template>
    <MyMaster>
        <div class="row">
            <!-- For Category and Information -->
            <div class="col-md-4">
                <div class="card bg-gray-100">
                    <div class="card-body">
                        <li class="list-group-item bg-bg text-white">
                            Label
                        </li>
                        <ul class="list-group label">
                            <li class="list-group-item bg-dark text-white">
                                <span class="fas fa-tags text-white text-small"></span>
                                &nbsp; &nbsp;
                                Laravel Note
                                <span class="badge badge-primary float-right">3</span>
                            </li>
                            <li class="list-group-item bg-dark text-white">
                                <span class="fas fa-tags text-white text-small"></span>
                                &nbsp; &nbsp;
                                Vue JS Note
                                <span class="badge badge-primary float-right">3</span>
                            </li>
                            <li class="list-group-item bg-dark text-white">
                                <span class="fas fa-tags text-white text-small"></span>
                                &nbsp; &nbsp;
                                Vue JS Note
                                <span class="badge badge-primary float-right">3</span>
                            </li>
                            <li class="list-group-item bg-dark text-white">
                                <span class="fas fa-tags text-white text-small"></span>
                                &nbsp; &nbsp;
                                Vue JS Note
                                <span class="badge badge-primary float-right">3</span>
                            </li>
                            <li class="list-group-item bg-dark text-white">
                                <a href="" class="float-right">View All</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card bg-gray-100">
                    <div class="card-body">
                        <li class="list-group-item bg-bg text-white">
                            Contribute Notes
                            <a href="" class="badge badge-dark  text-white float-right">All</a>
                        </li>
                        <ul class="list-group label">
                            <li class="list-group-item bg-dark text-white">
                                <i class="far fa-newspaper"></i>
                                &nbsp; &nbsp;
                                Laravel Note
                                <small> from</small>
                                <b class="text-primary">Myo Thant Kyaw</b>
                            </li>
                            <li class="list-group-item bg-dark text-white">
                                <i class="far fa-newspaper"></i>
                                &nbsp; &nbsp;
                                Vue Note
                                <small> from</small>
                                <b class="text-primary">Myo Thant Kyaw</b>
                            </li>
                            <li class="list-group-item bg-dark text-white">
                                <i class="far fa-newspaper"></i>
                                &nbsp; &nbsp;
                                Income Note
                                <small> from</small>
                                <b class="text-primary">Myo Thant Kyaw</b>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-dark">
                        <h3 class="text-white">Create Note</h3>
                    </div>
                    <div class="card-body">
                        <form action="">
                            <div class="form-group">
                                <input type="text" name="title" class="form-control border-0 bg-dark"
                                    placeholder="enter title" id="">
                            </div>
                            <div class="form-group">
                                <color :swatches="colorlist" v-model="color" inline background-color="32325D"/>
                            </div>
                            <div class="form-group" style="background:white;">
                                <quill-editor v-model:content="description" contentType="html" theme="snow" />
                            </div>
                            <input type="submit" value="Create" class="btn btn-dark">
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </MyMaster>
</template>
<script>
import color from "vue3-swatches";
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import MyMaster from './Layout/MyMaster.vue';

export default {
    name:"MyCreateNote",
    components:{ MyMaster, color, QuillEditor },
    data(){
        return{
            color:"#3398DB",
            colorlist:[],
            description:"",
        };
    },
    created(){
        this.$root.ColorLabel.color.map(c=>{
                this.colorlist.push(c.name);
        })
    },
    watch:{
        '$root.ColorLabel.color'(){
            this.$root.ColorLabel.color.map(c=>{
                this.colorlist.push(c.name);
            })
        }
    }
}
</script>