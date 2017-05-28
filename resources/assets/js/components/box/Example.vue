<template>
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
          <div class="panel-heading">Box</div>

        <div class="panel-body">
          
          <!-- data binding inputs -->
          <input type="text" v-model="msg"><br/>
          <span v-html="msg"></span>
          
          <!-- displaying objects -->
          <p>{{ user.first_name }}</p>
          <p v-if="active" v-text="user.last_name"></p>
          <p v-else>...</p>

          <!-- function call -->
          <button v-on:click="greet">Say Hi</button>

          <!-- events -->          
          <input type="text" 
            v-on:keyup="pressKey" 
            v-on:keyup.enter="pressedEnter">

        </div>

      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'box',
    data() {
      return {

        msg: "<h1>Hello world!</h1>",

        user: {
          first_name: 'John',
          last_name: 'Doe'
        },
        active: true,

        greet() {
          alert("Hi");
        },

        pressKey: (e) => {
          console.log(e.char);
        },
        pressedEnter: (e) => {
          console.log("Pressed Enter!");
        }

      }
    }
  }
</script>
