<template>
    <MyMaster :message="message">
        <div class="row">
            <MySideBar />
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-dark">
                        <h2 class="text-white">Contribute</h2>
                    </div>
                    <div class="card-body">
                        <form class="text-white">
                            <div class="form-group">
                                <label for="">Enter Email</label>
                                <input type="text" class="form-control" required placeholder="enter email">
                            </div>
                        </form>

                        <!--When email is found-->
                        <div class="card text-white">
                            <div class="card-header bg-primary">
                                <h2>Nay Aung Lin</h2>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img 
                                         src="https://cdn4.iconfinder.com/data/icons/small-n-flat/24/user-alt-512.png" 
                                         alt=""
                                         style="width:50%"
                                         />
                                    </div>
                                    <div class="col-md-8">
                                        <button class="btn btn-primary">Contribute</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-danger">User Not Found!</div>
                    </div>
                </div>
            </div>
        </div>
    </MyMaster>
</template>
<script>
import MyMaster from './Layout/MyMaster.vue';
import MySideBar from './Layout/MySideBar.vue';
export default {
    name: "MyContribute",
    components: { MyMaster, MySideBar },
    props:{message: Object},
};
</script>