<template>
  <div class="text-xs-center">
    <v-dialog v-model="dialog" width="500">
      <!--<template v-slot:activator="{ on }"><v-btn icon v-on="on"><v-icon>error</v-icon></v-btn></template>-->
      <v-card>
        <v-toolbar color="error" dark dense>
          <v-toolbar-title>Błąd!</v-toolbar-title>
        </v-toolbar>

        <v-card-text v-if="typeof errors === 'string'"><h4>{{errors}}</h4></v-card-text>
        <span v-else>
          <v-card-text v-for="(error, key) in errors" :key="key">
            <h4 v-if="typeof error === 'string'">{{error}}</h4>
            <span v-else><h4>{{key}}</h4>
              <p v-for="(detail, detailNumber) in error" :key="detailNumber">{{detail}}</p>
            </span>
          </v-card-text>
        </span>

        <v-card-actions>
          <v-btn color="primary" block flat class="mt-0" @click="dialog = false">Ok</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        dialog: false,
        errors: [],
      }
    },
    created() {
      EventBus.$on('showErrorDialog', (err) => {this.dialog = true; this.errors = err;});
    },
  }
</script>
