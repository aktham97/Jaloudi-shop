<template>
    <div class="container">

        <div class="row">

            <div class="col-lg-3">
                <br>
                <Men_clothing></Men_clothing>

            </div>
            <!-- /.col-lg-3 -->

            <div class="col-lg-8">
                <br>
                <br>
                <div class="row">


                    <div class="col-lg-4 col-md-6 mb-4" v-for="(pant,index) in pants" :key="index">
                        <div class="card h-100">
                            <a href="#"><img v-on:click="showNewRating(pant.id)" class="card-img-top"
                                             :src="`${$store.state.servicePath}/storage/${pant.image}`" alt=""></a>
                            <div class="card-body">
                                <h4 class="card-title">
                                    <a href="#">{{pant.name}}</a>
                                </h4>
                                <h5 style="color: red">${{pant.price}}</h5>
                                <p class="card-text">{{pant.description}}</p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted" v-if="pant.rating >= 4.5">&#9733; &#9733; &#9733; &#9733;
                                    &#9733;
                                </small>
                                <small class="text-muted" v-if="pant.rating >= 3.5 && pant.rating <= 4.5">&#9733;
                                    &#9733; &#9733; &#9733; &#9734;
                                </small>
                                <small class="text-muted" v-if="pant.rating >= 2.5 && pant.rating <= 3.5">&#9733;
                                    &#9733; &#9733; &#9734; &#9734;
                                </small>
                                <small class="text-muted" v-if="pant.rating >= 1.5 && pant.rating <= 2.5">&#9733;
                                    &#9733; &#9734; &#9734; &#9734;
                                </small>
                                <small class="text-muted" v-if="pant.rating >= 0.5 && pant.rating <= 1.5">&#9733;
                                    &#9734; &#9734; &#9734; &#9734;
                                </small>
                                <small class="text-muted" v-if="pant.rating < 0.5">&#9734; &#9734; &#9734; &#9734;
                                    &#9734;
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.col-lg-9 -->
            <div class="col-lg-1">
                <br>
                <br>
                <button  type="button" class="btn btn-primary fixed-button" v-on:click="showNewPant"><span
                    class="fa fa-plus"></span> Add New pant
                </button>

            </div>
        </div>
        <!-- /.row -->
        <div class="text-center" v-if="morePants">
            <button type="button" class="btn btn-primary btn-sm button-arrow-down" v-on:click="loadMorePants"><span class="fa fa-arrow-down"></span>Load More</button>
        </div>
        <div>
            <b-modal ref="newPantModal" hide-footer title="Add New pant">
                <div class="d-blockr">
                    <form v-on:submit.prevent="createPant">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" v-model="pantData.name"
                                   placeholder="Enter name">
                            <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" step="any" class="form-control" v-model="pantData.price" id="price"
                                   placeholder="price">
                            <div class="invalid-feedback" v-if="errors.price">{{errors.price[0]}}</div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <br>
                            <textarea rows="4" cols="50" id="description" v-model="pantData.description"></textarea>
                            <div class="invalid-feedback" v-if="errors.description">{{errors.description[0]}}</div>
                        </div>
                        <div class="form-check">
                            <label for="image">Image</label>
                            <div v-if="pantData.image.name">
                                <img src="" ref="newPantImageDisplay" class="w-150px"/>
                            </div>
                            <input type="file" class="form-control" ref="newPantImage" v-on:change="attachImage"
                                   id="image">
                            <div class="invalid-feedback" v-if="errors.image">{{errors.image[0]}}</div>
                        </div>
                        <hr>
                        <div class="text-right">
                            <button type="button" class="btn btn-default" v-on:click="hideNewPant">Cancel</button>
                            <button type="submit" class="btn btn-primary"><span class="fa fa-check"></span>Save</button>
                        </div>
                    </form>
                </div>
            </b-modal>
            <b-modal ref="newRatingModal" hide-footer title="Thank you for rating">
                <div class="d-blockr">
                    <form v-on:submit.prevent="addNewRating">
                        <div class="form-group">
                            <label for="rating">Select your rating</label>
                            <select class="form-control" id="rating" v-model="pantData.rating">
                                <option value="">Select a rating</option>
                                <option value="5">Excellent</option>
                                <option value="4">Very Good</option>
                                <option value="3">Average</option>
                                <option value="2">Poor</option>
                                <option value="1">Terrible</option>
                            </select>
                            <div class="invalid-feedback" v-if="errors.rating">{{errors.rating[0]}}</div>
                        </div>
                        <hr>
                        <div class="text-right">
                            <button type="button" class="btn btn-default" v-on:click="hideNewRating">Cancel</button>
                            <button type="submit" class="btn btn-primary"><span class="fa fa-check"></span>Save</button>
                        </div>
                    </form>
                </div>
            </b-modal>
        </div>
    </div>
</template>
<script>
    import * as pant_service from '../../services/men/pant_service';
    import Men_clothing from "../../components/Men_clothing";

    export default {
        name: 'pants',
        components: {Men_clothing},
        data() {
            return {
                pants: {},
                pantData: {
                    name: '',
                    price: '',
                    description: '',
                    rating: '',
                    image: '',
                    id:''
                },
                morePants:false,
                nextPage:0,
                errors: {}
            }
        },
        mounted() {
            this.loadPantts();
        },
        methods: {
            loadPantts: async function () {
                try {
                    const response = await pant_service.loadPants();
                    this.pants = response.data.data;
                    if (response.data.current_page < response.data.last_page)
                    {
                        this.morePants = true;
                        this.nextPage = response.data.current_page + 1;
                    }
                    else
                    {
                        this.morePants = false;
                    }
                } catch (err) {
                    this.flashMessage.error({
                        message: 'Some error occurred , Please refresh!',
                        time: 5000
                    });
                }
            },
            loadMorePants: async function(){
                try {
                    const response = await pant_service.loadMorePants(this.nextPage);
                    if (response.data.current_page < response.data.last_page)
                    {
                        this.morePants = true;
                        this.nextPage = response.data.current_page + 1;
                    }
                    else
                    {
                        this.morePants = false;
                    }
                    response.data.data.forEach(data => {
                        this.pants.push(data);
                    });

                } catch (err) {
                    this.flashMessage.error({
                        message: 'Some error occurred during load more pants , Please refresh!',
                        time: 5000
                    });
                }
            },

            attachImage() {
                this.pantData.image = this.$refs.newPantImage.files[0];
                let reader = new FileReader();
                reader.addEventListener('load', function () {
                    this.$refs.newPantImageDisplay.src = reader.result;
                }.bind(this), false);
                reader.readAsDataURL(this.pantData.image);

            },
            hideNewPant() {
                this.$refs.newPantModal.hide();

            },
            showNewPant() {
                this.$refs.newPantModal.show();

            },
            hideNewRating() {
                this.$refs.newRatingModal.hide();

            },
            showNewRating(id) {
                this.pantData.id=id;
                this.$refs.newRatingModal.show();

            },
            addNewRating: async function(){
                let formData = new FormData();
                formData.append('rating', this.pantData.rating);
                try {
                    const response = await pant_service.editRating(this.pantData.id,formData);
                    this.hideNewRating();
                    this.flashMessage.success({
                        message: 'Rating added successfully!',
                        time: 5000
                    });
                    this.pantData = {
                        id: '',
                        rating: '',
                    };
                }catch (error) {
                    switch (error.response.status) {
                        case 422:
                            this.errors = error.response.data.errors;
                            break;
                        default:
                            this.flashMessage.error({
                                message: 'Some error occurred , Please try again!',
                                time: 5000
                            });
                            break;
                    }
                }
            },
            createPant: async function () {
                let formData = new FormData();
                formData.append('name', this.pantData.name);
                formData.append('price', this.pantData.price);
                formData.append('description', this.pantData.description);
                formData.append('image', this.pantData.image);

                try {
                    const response = await pant_service.createPant(formData);
                    this.pants.unshift(response.data);
                    this.hideNewPant();
                    this.flashMessage.success({
                        message: 'Pant Stored successfully!',
                        time: 5000
                    });
                    this.pantData = {
                        name: '',
                        price: '',
                        description: '',
                        image: ''
                    };
                } catch (error) {
                    switch (error.response.status) {
                        case 422:
                            this.errors = error.response.data.errors;
                            break;
                        default:
                            this.flashMessage.error({
                                message: 'Some error occurred , Please try again!',
                                time: 5000
                            });
                            break;
                    }
                }


            }
        }
    }
</script>
