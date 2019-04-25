<template>
<v-layout row wrap>
  <v-flex xs12 lg6>
  <v-toolbar color="blue darken-4" dark dense>
    <v-toolbar-title>Nowe zamówienie</v-toolbar-title>
    <v-spacer></v-spacer>
    <v-btn icon><v-icon>info</v-icon></v-btn>
  </v-toolbar>
  <v-card class="pa-1">
    <v-card-text>
      <h4>Dane klienta</h4>
      <v-combobox
        label="Imię i nazwisko"
        v-model="fullname"
        :rules="[() => !!fullname || 'To pole jest wymagane']"
        :items="states"
        counter="50"
        hide-no-data
        hide-selected
        prepend-icon="account_box"
      ></v-combobox>

      <v-combobox
        label="Numer telefonu"
        return-masked-value
        mask="### ### ###"
        counter="11"
        hide-no-data
        hide-selected
        prepend-icon="phone"
      ></v-combobox>

      <v-text-field
        label="Zaliczka w PLN"
        type="number"
        prepend-icon="attach_money"
        suffix="zł"
      ></v-text-field>

      <h4>Transport</h4>
      <hr>
      <v-radio-group v-model="transportType" row>
        <v-radio label="W mieście" value="city-delivery"></v-radio>
        <v-radio label="Poza miastem" value="outside-city-delivery"></v-radio>
        <v-radio label="Darmowy" value="free-delivery"></v-radio>
      </v-radio-group>
      <v-combobox v-if="transportType=='outside-city-delivery'"
        label="Miejscowość"
        v-model="model"
        :items="states"
        counter="50"
        hide-no-data
        hide-selected
        prepend-icon="location_on"
      ></v-combobox>
      <v-text-field v-if="transportType=='outside-city-delivery'"
        label="Odległość w Km"
        type="number"
        prepend-icon="map"
        suffix="Km"
      ></v-text-field>
      <v-flex xs12 lg6>
      <v-menu
        ref="menu1"
        v-model="menu1"
        :close-on-content-click="false"
        :nudge-right="40"
        lazy
        transition="scale-transition"
        offset-y
        full-width
        max-width="290px"
        min-width="290px">
        <template v-slot:activator="{ on }">
          <v-text-field
            label="Ostateczny termin realizacji"
            v-model="dateFormatted"
            persistent-hint
            prepend-icon="event"
            @blur="date = parseDate(dateFormatted)"
            v-on="on"
          ></v-text-field>
        </template>
      <v-date-picker v-model="date" no-title @input="menu1 = false"></v-date-picker>
      </v-menu>
      </v-flex>
      <hr>

      <h4>Promocje</h4>
      <p>Łączna kwota zamówień klienta to xx xxx zł </br> Ostatnie zamówienie opiewało na kwotę xxx zł </p>
        <v-layout wrap>
          <v-flex xs12 md6><v-text-field label="Rabat w %" v-model="percentDiscount"></v-text-field></v-flex>
          <v-flex xs12 md6><v-text-field label="Rabat w PLN" suffix="zł" v-model="getMoneyDiscount"></v-text-field></v-flex>
        </v-layout>
      <hr>

      <h1>Razem: {{ totalValueInPennyShowed }} zł</h1>
      <p class="grey--text">Jeśli chcesz wydrukować to zamówienie jeszcze raz po prostu kliknij zatwierdź</p>
      <v-card-actions>
        <v-btn color="info">Dodaj produkt</v-btn>
        <v-layout align-center justify-end><v-btn color="success">Zatwierdź</v-btn></v-layout>
      </v-card-actions>
    </v-card-text>
  </v-card>
  </v-flex>


  <!--PRAWA STRONA-->
  <v-flex xs12 lg6>
  <v-toolbar color="indigo" dark dense>
    <v-toolbar-title>Tafle szkła</v-toolbar-title>
    <v-spacer></v-spacer>
    <v-btn icon><v-icon>info</v-icon></v-btn>
  </v-toolbar>
      <v-card class="pa-1">
        <v-card-text>
          PRAWA STRONA
        </v-card-text>
      </v-card>
  </v-flex>
</v-layout>
</template>




<script>
  export default {
    data: vm => ({
      date: new Date().toISOString().substr(0, 10),
      dateFormatted: vm.formatDate(new Date().toISOString().substr(0, 10)),
      menu1: false,
      isEditing: false,
      model: null,
      inputvalue: 0,
      states: [
        'Alabama', 'Alaska', 'American Samoa', 'Arizona',
        'Arkansas', 'California', 'Colorado', 'Connecticut',
        'Delaware', 'District of Columbia', 'Federated States of Micronesia',
        'Florida', 'Georgia', 'Guam', 'Hawaii', 'Idaho',
        'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky',
        'Louisiana', 'Maine', 'Marshall Islands', 'Maryland',
        'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi',
        'Missouri', 'Montana', 'Nebraska', 'Nevada',
        'New Hampshire', 'New Jersey', 'New Mexico', 'New York',
        'North Carolina', 'North Dakota', 'Northern Mariana Islands', 'Ohio',
        'Oklahoma', 'Oregon', 'Palau', 'Pennsylvania', 'Puerto Rico',
        'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee',
        'Texas', 'Utah', 'Vermont', 'Virgin Island', 'Virginia',
        'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'
      ],
      transportType: 'city-delivery',
      percentDiscount: 0,
      moneyDiscount: 0,
      totalValueInPenny: 1000,
      totalValueInPennyShowed: 1000,

    }),

    methods: {
      formatDate (date) {
        if (!date) return null

        const [year, month, day] = date.split('-')
        return `${year}/${month}/${day}`
      },
      parseDate (date) {
        if (!date) return null

        const [year, month, day] = date.split('/')
        return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
      }
    },
    computed: {
      computedDateFormatted() {
        return this.formatDate(this.date)
      },
      getPercentDiscount: {
        get: function(){
          return this.totalValueInPenny * this.percentDiscount ;
        },
        set: function(setNames) {
          this.lastName = names[last]
        },
      },
      getMoneyDiscount: {
        get: function(){
          let total  = this.totalValueInPenny;
          let perc = this.percentDiscount;
          this.moneyDiscount = total * (perc / 100);
          this.totalValueInPennyShowed = this.totalValueInPenny - this.moneyDiscount;
          return this.moneyDiscount;
        },
        set: function(money) {
          let total  = this.totalValueInPenny;
          let perc = this.percentDiscount;
          this.totalValueInPenny = money;
        },
      },


    },
    watch: {
      date (val) {
        this.dateFormatted = this.formatDate(this.date)
      }
    },

  }
</script>
