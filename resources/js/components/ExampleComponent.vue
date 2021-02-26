<template>
  <div class="container">
    <div class="title m-b-md">Car</div>
    <div class="alert alert-danger" role="alert" v-bind:class="{ hidden: hasError }">All fields are required  </div>
    <div class="form-group">
      <label for="make">Make</label>
      <input
        type="text" class="form-control"  id="make" required placeholder="Make" name="make" v-model="newCar.make"/>
    </div>

    <div class="form-group">
      <label for="model">Model</label>
      <input type="text" class="form-control" id="model" required placeholder="Model" name="model"  v-model="newCar.model"/>
    </div>

    <button class="btn btn-primary" @click.prevent="createCar()">Add Car</button>

      <table class="table table-striped" id="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Make</th>
            <th scope="col">Model</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="car in cars">
            <th scope="row">{{ car.id }}</th>
            <td>{{ car.make }}</td>
            <td>{{ car.model }}</td>
  
            <td @click="setVal(car.id, car.make, car.model)"
           class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">
              <i class="fa fa-pencil"></i>
            </td>
            <td @click.prevent="deleteCar(car)" class="btn btn-danger">
              <i class="fa fa-trash"></i>
            </td>
          </tr>
        </tbody>
      </table>
     
          <div id="myModal" class="modal fade modal-lg" role="dialog" style=" margin: 30px 20%;" >
              <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
              <div class="modal-body">
                <input type="hidden" disabled class="form-control"  id="e_id" name="id"  required :value="this.e_id" />
               
                Make:
                <input type="text" class="form-control"  id="e_make" name="make" required :value="this.e_make"  />
               
                Model:
                <input type="text"  class="form-control"  id="e_model"  name="model" required :value="this.e_model"/>
              </div>
        
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" @click="editCar()">
                  Save changes
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                  Close
                </button>
              </div>
               </div>
              </div>
          </div>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      newCar: { make: "", model: "" },
      hasError: true,
      cars: [],
      e_make:'',
      e_model:'',
      e_id:'',
    };
  },
  methods: {
    createCar: function createCar() {
      var input = this.newCar;
      var _this = this;
      if (input["make"] == "" || input["model"] == "") {
        this.hasError = false;
      } else {
        this.hasError = true;
        axios
          .post("/storeCar", input)
          .then(function (response) {
         _this.newCar = { make: "", model: "" };     /// to clear (reset) data after post 
            _this.getCars();
          })
          .catch((error) => {
            console.log("Insert: " + error);
          });
      }
    },

    getCars: function getCars() {
      var _this = this;
      axios
        .get("/getCars")
        .then(function (response) {
          _this.cars = response.data;
        })
        .catch((error) => {
          console.log("Get All: " + error);
        });
    },

    setVal(val_id, val_make, val_model) {
      this.e_id = val_id;
      this.e_make = val_make;
      this.e_model = val_model;
    },

    editCar: function () {
      var _this = this;
      var id_val_1 = document.getElementById("e_id");
      var make_val_1 = document.getElementById("e_make");
      var model_val_1 = document.getElementById("e_model");
      var model = document.getElementById("myModal").value;
      
      axios.post("/editCars/" + id_val_1.value, {
          val_1: make_val_1.value,
          val_2: model_val_1.value,
        })
        .then((response) => {
          _this.getCars();
        });
    },

    deleteCar: function deleteCar(car) {
      var _this = this;
      axios.post("/deleteCar/" + car.id)
        .then(function (response) {
          _this.getCars();
        })
        .catch((error) => {
          console.log("Delete car: " + error);
        });
    },
  },
  mounted: function mounted() {
    this.getCars();
  },
};
</script>
