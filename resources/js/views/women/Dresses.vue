<template>
    <div class="container">

        <div class="row">

            <div class="col-lg-3">
                <br>
                <women_clothing></women_clothing>


            </div>
            <!-- /.col-lg-3 -->

            <div class="col-lg-8">
                <br>
                <br>
                <div class="row">


                    <div class="col-lg-4 col-md-6 mb-4" v-for="(dress,index) in dresses" :key="index">
                        <div class="card h-100">
                            <a href="#"><img v-on:click="showNewRating(dress.id)" class="card-img-top"
                                             :src="`${$store.state.servicePath}/storage/${dress.image}`" alt=""></a>
                            <div class="card-body">
                                <h4 class="card-title">
                                    <a href="#">{{dress.name}}</a>
                                </h4>
                                <h5 style="color: red">${{dress.price}}</h5>
                                <p class="card-text">{{dress.description}}</p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted" v-if="dress.rating >= 4.5">&#9733; &#9733; &#9733; &#9733;
                                    &#9733;
                                </small>
                                <small class="text-muted" v-if="dress.rating >= 3.5 && dress.rating <= 4.5">&#9733;
                                    &#9733; &#9733; &#9733; &#9734;
                                </small>
                                <small class="text-muted" v-if="dress.rating >= 2.5 && dress.rating <= 3.5">&#9733;
                                    &#9733; &#9733; &#9734; &#9734;
                                </small>
                                <small class="text-muted" v-if="dress.rating >= 1.5 && dress.rating <= 2.5">&#9733;
                                    &#9733; &#9734; &#9734; &#9734;
                                </small>
                                <small class="text-muted" v-if="dress.rating >= 0.5 && dress.rating <= 1.5">&#9733;
                                    &#9734; &#9734; &#9734; &#9734;
                                </small>
                                <small class="text-muted" v-if="dress.rating < 0.5">&#9734; &#9734; &#9734; &#9734;
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
                <button  type="button" class="btn btn-primary fixed-button" v-on:click="showNewDress"><span
                    class="fa fa-plus"></span> Add New dress
                </button>

            </div>
        </div>
        <!-- /.row -->
        <div class="text-center" v-if="moreDresses">
            <button type="button" class="btn btn-primary btn-sm button-arrow-down" v-on:click="loadMoreDresses"><span class="fa fa-arrow-down"></span> Load More</button>
        </div>
        <div>
            <b-modal ref="newDressModal" hide-footer title="Add New dress">
                <div class="d-blockr">
                    <form v-on:submit.prevent="createDress">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" v-model="dressData.name"
                                   placeholder="Enter name">
                            <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" step="any" class="form-control" v-model="dressData.price" id="price"
                                   placeholder="price">
                            <div class="invalid-feedback" v-if="errors.price">{{errors.price[0]}}</div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <br>
                            <textarea rows="4" cols="50" id="description" v-model="dressData.description"></textarea>
                            <div class="invalid-feedback" v-if="errors.description">{{errors.description[0]}}</div>
                        </div>
                        <div class="form-check">
                            <label for="image">Image</label>
                            <div v-if="dressData.image.name">
                                <img src="" ref="newDressImageDisplay" class="w-150px"/>
                            </div>
                            <input type="file" class="form-control" ref="newDressImage" v-on:change="attachImage"
                                   id="image">
                            <div class="invalid-feedback" v-if="errors.image">{{errors.image[0]}}</div>
                        </div>
                        <hr>
                        <div class="text-right">
                            <button type="button" class="btn btn-default" v-on:click="hideNewDress">Cancel</button>
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
                            <select class="form-control" id="rating" v-model="dressData.rating">
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
    import * as dress_service from '../../services/women/dress_service';
    import Women_clothing from "../../components/Women_clothing";

    export default {
        name: 'dresses',
        components: {Women_clothing},
        data() {
            return {
                dresses: {},
                dressData: {
                    name: '',
                    price: '',
                    description: '',
                    rating: '',
                    image: '',
                    id:''
                },
                moreDresses:false,
                nextPage:0,
                errors: {}
            }
        },
        mounted() {
            this.loadDresses();
        },
        methods: {
            loadDresses: async function () {
                try {
                    const response = await dress_service.loadDresses();
                    this.dresses = response.data.data;
                    if (response.data.current_page < response.data.last_page)
                    {
                        this.moreDresses = true;
                        this.nextPage = response.data.current_page + 1;
                    }
                    else
                    {
                        this.moreDresses = false;
                    }
                } catch (err) {
                    this.flashMessage.error({
                        message: 'Some error occurred , Please refresh!',
                        time: 5000
                    });
                }
            },
            loadMoreDresses: async function(){
                try {
                    const response = await dress_service.loadMoreDresses(this.nextPage);
                    if (response.data.current_page < response.data.last_page)
                    {
                        this.moreDresses = true;
                        this.nextPage = response.data.current_page + 1;
                    }
                    else
                    {
                        this.moreDresses = false;
                    }
                    response.data.data.forEach(data => {
                        this.dresses.push(data);
                    });

                } catch (err) {
                    this.flashMessage.error({
                        message: 'Some error occurred during load more dresses , Please refresh!',
                        time: 5000
                    });
                }
            },

            attachImage() {
                this.dressData.image = this.$refs.newDressImage.files[0];
                let reader = new FileReader();
                reader.addEventListener('load', function () {
                    this.$refs.newDressImageDisplay.src = reader.result;
                }.bind(this), false);
                reader.readAsDataURL(this.dressData.image);

            },
            hideNewDress() {
                this.$refs.newDressModal.hide();

            },
            showNewDress() {
                this.$refs.newDressModal.show();

            },
            hideNewRating() {
                this.$refs.newRatingModal.hide();

            },
            showNewRating(id) {
                this.dressData.id=id;
                this.$refs.newRatingModal.show();

            },
            addNewRating: async function(){
                let formData = new FormData();
                formData.append('rating', this.dressData.rating);
                try {
                    const response = await dress_service.editRating(this.dressData.id,formData);
                    this.hideNewRating();
                    this.flashMessage.success({
                        message: 'Rating added successfully!',
                        time: 5000
                    });
                    this.dressData = {
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
            createDress: async function () {
                let formData = new FormData();
                formData.append('name', this.dressData.name);
                formData.append('price', this.dressData.price);
                formData.append('description', this.dressData.description);
                formData.append('image', this.dressData.image);

                try {
                    const response = await dress_service.createDress(formData);
                    this.dresses.unshift(response.data);
                    this.hideNewDress();
                    this.flashMessage.success({
                        message: 'Dress Stored successfully!',
                        time: 5000
                    });
                    this.dressData = {
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
