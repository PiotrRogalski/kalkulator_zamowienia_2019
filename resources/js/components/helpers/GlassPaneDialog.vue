<template>
<v-layout row justify-center>
<v-dialog v-model="isDialogOpen" width="600px" persistent>
<v-card>
  <v-toolbar color="blue-grey" dark dense><v-toolbar-title>{{ formTitle }}</v-toolbar-title></v-toolbar>
  <v-card-text pa-2>
      <h4>Rodzaj szkła</h4>
      <v-layout>
          <v-flex xs12 md5 px-2><v-select label="Materiał" :items="materials" :disabled="materials.length <= 0" item-text="name"
              item-value="id" prepend-icon="terrain" @change="choosedMaterialId" :value="materials[0]"></v-select></v-flex>
          <v-flex xs12 md4 px-2>
            <v-select label="Typ" :items="materialTypes"  :disabled="materialTypes.length <= 1" item-text="name" prepend-icon="crop_original"
              item-value="id" @change="choosedMaterialTypeId" :value="materialTypes[0]"></v-select></v-flex>
          <v-flex xs12 md3 px-2 v-if="glassMarks <= 0">
            <v-select label="Grubość" :items="thickness" item-text="name" :disabled="thickness.length <= 1"
              append-icon="vertical_align_center" @change="choosedThicknessName" :value="thickness[0]"
            ></v-select></v-flex>
          <v-flex xs12 md3 px-2 v-else>
            <v-select label="Oznaczenie" :items="glassMarks" item-text="name" :disabled="glassMarks.length <= 1"
              append-icon="description" @change="choosedGlassMarksName" :value="glassMarks[0]"
            ></v-select></v-flex>
      </v-layout>
      <h4>Wymiary tafli</h4>
      <v-layout align-center justify-space-around row>
        <v-flex px-3 xs12 md5><v-text-field label="Szerokość" suffix="cm" prepend-icon="code" v-model="glassPaneWidth"
              @change="choosedGlassPaneWidth"></v-text-field></v-flex>
        <v-btn flat disabled fab small><v-icon dark>clear</v-icon></v-btn>
        <v-flex px-3 xs12 md5><v-text-field label="Wysokość" suffix="cm" prepend-icon="unfold_more" v-model="glassPaneHeight"
              @change="choosedGlassPaneHeight"></v-text-field></v-flex>
      </v-layout>
      <h4>Rodzaj szlifu</h4>
      <v-layout>
        <v-flex xs12>
          <v-select label="Nazwa" prepend-icon="tune" :items="cutModels" item-value="id" item-text="name"
                    @change="choosedCutModelId"  :value="cutModels[0]" :disabled="cutModels.length <= 1"
          ></v-select>
        </v-flex>
      </v-layout>

    <v-btn block color="info" dark @click="addHole">DODAJ OTWORY</v-btn>
    <v-card v-if="holes.length > 0"><v-card-text>
      <v-layout align-start justify-start row v-for="(item, key) in holes" :key="key">
      <v-flex px-3 xs5><v-text-field label="Średnica" suffix="mm" prepend-icon="block" v-model="holes[key].diameter"
             @keyup="changeTotalValueInPenny"></v-text-field></v-flex>
      <v-flex px-3 xs5><v-text-field label="Ilość" suffix="szt" prepend-icon="filter_none" v-model="holes[key].number"
             @keyup="changeTotalValueInPenny"></v-text-field></v-flex>
      <v-flex><v-btn flat fab @click="deleteHole(item)"><v-icon>close</v-icon></v-btn></v-flex>
    </v-layout>
    </v-card-text></v-card>

    <v-btn block color="orange darken-1" dark @click="addService">DODAJ USŁUGI</v-btn>
    <v-card v-if="services.length > 0"><v-card-text>
      <v-layout align-start justify-start row v-for="(item, key) in services" :key="key">
      <v-flex px-3 xs6><v-select label="Nazwa" :items="servicesList" item-text="name" item-value="id" v-model="services[key].service_list_id"
             @change="changeTotalValueInPenny"></v-select></v-flex>
      <v-flex px-3 xs4><v-text-field label="Ilość" :suffix="serviceUnit(services[key].service_list_id)" v-model="services[key].quantity"
             @keyup="changeTotalValueInPenny" prepend-icon="filter_none"></v-text-field></v-flex>
      <v-flex><v-btn flat fab @click="deleteService(item)"><v-icon>close</v-icon></v-btn></v-flex>
    </v-layout>
    </v-card-text></v-card>

    <v-btn block color="orange darken-4" dark @click="addAdditionalService">DODAJ DODATKOWE USŁUGI</v-btn>
    <v-card v-if="additionalServices.length > 0"><v-card-text>
      <v-layout align-start justify-start row wrap v-for="(item, key) in additionalServices" :key="key">
        <v-flex px-3 xs6><v-text-field label="Cena" suffix="zł" v-model="additionalServices[key].price" prepend-icon="attach_money"
               @keyup="changeTotalValueInPenny"></v-text-field></v-flex>
        <v-flex><v-btn flat fab @click="deleteAdditionalService(item)"><v-icon>close</v-icon></v-btn></v-flex>
        <v-flex px-3 xs12><v-textarea box name="additional-service-body" label="Opis" v-model="additionalServices[key].description"></v-textarea></v-flex>
    </v-layout>
    </v-card-text></v-card>

    <h4 class="mt-4">Ilość sztuk tego produktu</h4>
    <v-layout align-center justify-space-around row>
      <v-flex px-3 xs12><v-text-field label="Ilość" suffix="szt" prepend-icon="scatter_plot" v-model="glassPaneQuantity"
            @keyup="changeTotalValueInPenny"></v-text-field></v-flex>
    </v-layout>

    <h2>Cena produktu: {{ totalValueInPennyShowed }}</h2>
    <v-btn @click="showWhatIgot">Pokaż jakie zmienne mam</v-btn>
  </v-card-text>
  <v-card-actions>
    <v-btn color="amber darken-4" flat dark @click="closeDialog">Anuluj</v-btn>
    <v-spacer></v-spacer>
    <v-btn color="green darken-1" dark @click="closeDialog">Zapisz</v-btn>
  </v-card-actions>
</v-card>
</v-dialog>
</v-layout>
</template>
<script>
  export default {
    props: ['obj'],
    data () {return {
      isDialogOpen: false,
      materials: [], materialTypes: [], thickness: [], cutModels: [], glassModels: [], glassMarks: [],
      holes: [], additionalServices: [], services: [],
      totalValueInPennyShowed: '0 zł', totalValueInPenny: 0,
      glassPaneQuantity: 0, glassPaneWidth: 0, glassPaneHeight: 0,
      choosenMaterialId: 1, choosenMaterialTypeId: null, choosenThicknessName: null, choosenGlassMarksName: null,
      choosenGlassModelId: null,
      choosenCutModelId: null,
      allMaterialTypes: [], allCutModels: [], holePrices: [], servicesList: [],
    }},
    created() {
      this.getMaterials();
      this.getMaterialTypes();
      this.getGlassModels();
      this.getCutModels();
      this.getServicesList();
      this.getHolePrices();
      this.lisen();
    },
    computed: {
      formTitle () {return nd2.isEmpty(this.obj) ? 'Dodaj produkt' : 'Edytuj produkt'},
    },
    methods: {
      lisen(){
        EventBus.$on('openAddGlassPaneDialog', () => {this.isDialogOpen = true;});
        EventBus.$on('closeAddGlassPaneDialog', () => {this.isDialogOpen = false;});
      },
      closeDialog(){EventBus.$emit('closeAddGlassPaneDialog');},
      addHole() {let obj = {number: '', diameter: ''}; this.holes.push(obj);},
      deleteHole(item) {let index = this.holes.indexOf(item); this.holes.splice(index, 1); this.changeTotalValueInPenny();},
      addService() {let obj = {service_list_id: '', quantity: ''}; this.services.push(obj);},
      deleteService(item) {let index = this.services.indexOf(item); this.services.splice(index, 1); this.changeTotalValueInPenny();},
      addAdditionalService() {let obj = {price: '', description: ''}; this.additionalServices.push(obj);},
      deleteAdditionalService(item) {let index = this.additionalServices.indexOf(item); this.additionalServices.splice(index, 1); this.changeTotalValueInPenny();},
      //Get from database
      getMaterials() {axios.get('/api/material/all').then(res =>  this.gettedMaterials(res.data)).catch(e => console.log(e));},
      getMaterialTypes() {axios.get('/api/material-types/all').then(res => this.gettedMaterialTypes(res.data)).catch(e => console.log(e));},
      getCutModels() {axios.get('/api/cut-models/all').then(res => this.gettedCutModels(res.data)).catch(e => console.log(e));},
      getGlassModels() {axios.get('/api/glass-models/all').then(res => this.gettedGlassModels(res.data)).catch(e => console.log(e));},
      getHolePrices() {axios.get('/api/hole-prices/all').then(res => this.holePrices = res.data).catch(e => console.log(e));},
      getServicesList() {axios.get('/api/services-list/all').then(res => this.servicesList = res.data).catch(e => console.log(e));},
      //Countable getters
      //Show methods
      showWhatIgot(){
        // console.log(this.choosenMaterialId);
        // console.log(this.choosenMaterialTypeId);
        // console.log(this.choosenThicknessName);
        // console.log(this.choosenGlassModelId);
        // console.log(this.choosenCutModelId);
        // console.log(this.choosenGlassMarksName);
        // console.log(this.materials);
        // console.log(this.materialTypes);
        // console.log(this.thickness);
        // console.log(this.glassMarks);
        // console.log(this.cutModels);
        // console.log(this.glassModels);
        // console.log(this.holes);
        // console.log(this.services);
        // console.log(this.additionalServices);
        // console.log(this.servicesList);
        // console.log(this.holePrices);
      },
      //Getters counted
      gettedMaterials(data) {
        this.materials = data;
      },
      gettedMaterialTypes(data) {
        this.allMaterialTypes = data;
        this.allMaterialTypes.unshift({id: null, name: 'Brak'});
      },
      gettedGlassModels(data) {
        this.glassModels = data;
        this.changeMaterialTypesList();
        this.changeGlassModelThicknessList();
      },
      gettedCutModels(data) {
        this.allCutModels = data;
        this.changeCutModelsList();
      },

      //Selectbox choosed options - what to do if i check smth
      choosedGlassPaneWidth(val) {
        //validacja wprowadzonej wartości i usuwa z tego litery
        this.glassPaneWidth = 99;
        this.changeTotalValueInPenny();
      },
      choosedGlassPaneHeight(val) {
        //validacja i zmiana wartosci - bez liter itp
        //tak jak ta powyzej wywoluje event zmiany ceny
        this.glassPaneHeight = 99;
        this.changeTotalValueInPenny();
      },
      choosedMaterialId(id){
        this.choosenMaterialId = id;
        this.changeMaterialTypesList();
        this.changeGlassModelGlassMarksList();
        this.changeGlassModelThicknessList();
        this.changeCutModelsList();
      },
      choosedMaterialTypeId(id){
        this.choosenMaterialTypeId = id;
        this.changeGlassModelGlassMarksList();
        this.changeGlassModelThicknessList();
        this.changeCutModelsList();
      },
      choosedThicknessName(name){
          this.choosenThicknessName = name;
          this.changeCutModelsList();
          this.changeGlassModelId();
      },
      choosedCutModelId(id){
        this.choosenCutModelId = id;
        this.changeTotalValueInPenny();
      },
      choosedGlassMarksName(name){
        this.choosenGlassMarksName = name;
        this.changeGlassModelThicknessList();
        this.changeCutModelsList();
      },

      //Changed options - update lists in selectboxes
      changeTotalValueInPennyShow() {
        //zmien sposob wyswietlania tej informacji (ceny) i wyswietl
        this.totalValueInPennyShowed = this.totalValueInPenny;
      },
      changeTotalValueInPenny() {
        let glassModelId = this.choosenGlassModelId;
        let cutModelId = this.choosenCutModelId;
        let width = this.glassPaneWidth;
        let height = this.glassPaneHeight;
        let glassModels = this.getChoosedGlassModel(['id','price']);
        let cutModels = this.getChoosedCutModel(['id','price']);
        let glassModel = glassModels[0];
        let cutModel = cutModels[0];
        let canCountGlassPanePrice = (width != 0 && height != 0 && glassModelId > 0 && glassModelId != null);
        let glassModelLoadedOk = ((glassModelId*1) === (glassModel.id*1));
        let cutModelLoadedOk = false;
        if (cutModel != null){cutModelLoadedOk = ((cutModelId*1) === (cutModel.id*1));}
        let canCountPrice = (canCountGlassPanePrice && glassModelLoadedOk && cutModelLoadedOk);

        if (canCountPrice) {
          let glassModelPrice = this.countGlassModelPrice();
        } else {
          this.totalValueInPenny = 0;
        }
        this.changeTotalValueInPennyShow();
      },

      changeGlassModelId(){
        let glassModelIds = [];
        this.choosenGlassModelId = null;

        glassModelIds = this.getChoosedGlassModel(['id']);

        if (glassModelIds.length > 0) {
          this.choosenGlassModelId = glassModelIds[0].id;
          this.changeCutModelsList();
          this.changeTotalValueInPenny();
        }
      },
      changeGlassModelGlassMarksList() {
        let data = this.glassModels.sort((a,b) => a.glass_mark - b.glass_mark);
        let materialId = this.choosenMaterialId;
        let materialTypeId = this.choosenMaterialTypeId;
        this.glassMarks = [];

        this.glassMarks = data.filter(function(obj) {
          let materialOK = (obj.material_id == materialId);
          let materialTypeOK = (obj.material_type_id == materialTypeId);
          let glassMarkOK = (obj.glass_mark != null);
          let validRow = (materialOK && materialTypeOK && glassMarkOK);

          return validRow;
        }).map(function(obj) {return {name: obj.glass_mark}});

        if (this.glassMarks.length > 0) {
          this.choosenGlassMarksName = this.glassMarks[0].name;
        } else {
          this.choosenGlassMarksName = null;
        }
      },

      changeGlassModelThicknessList() {
        let data = this.glassModels.sort((a,b) => a.thickness - b.thickness);
        let materialId = this.choosenMaterialId;
        let materialTypeId = this.choosenMaterialTypeId;
        let glassMarkName = this.choosenGlassMarksName;
        this.thickness = [];

        this.thickness = data.filter(function(obj) {
          let materialOK = (obj.material_id == materialId);
          let materialTypeOK = (obj.material_type_id == materialTypeId);
          let glassMarkOK = (obj.glass_mark == glassMarkName);
          let validRow = (materialOK && materialTypeOK && glassMarkOK);

          return validRow;
        }).map(function(obj) {return {name: obj.thickness/1000 + ' mm'}});

        if (this.thickness.length > 0) {
          this.choosenThicknessName = this.thickness[0].name;
          this.changeGlassModelId();
        } else {
          this.choosenThicknessName = null;
        }
      },

      changeMaterialTypesList() {
        let data = this.glassModels.sort((a,b) => a.material_type_id - b.material_type_id);
        if (data.length === 0) {return false;}
        let materialId = this.choosenMaterialId;
        let materialTypeIds = [];
        this.materialTypes = [];

        materialTypeIds = data.filter(function(obj) { return (obj.material_id == materialId); })
                              .map(function(obj) { return obj.material_type_id });

        let materialTypesDistinctIds = [...new Set(materialTypeIds)];
        data = this.allMaterialTypes;

        for(let index in data) {
          if (materialTypesDistinctIds.indexOf(data[index].id) != -1) {
            let obj = {id: data[index].id, name:data[index].name};
            this.materialTypes.push(obj);
          }
        }

        if (this.materialTypes.length > 0) {
          this.choosenMaterialTypeId = this.materialTypes[0].id;
        } else {
          this.choosenMaterialTypeId = null;
        }
      },

      changeCutModelsList() {
        let data = this.allCutModels.sort((a,b) => a.id - b.id);
        let materialId = this.choosenMaterialId;
        let materialTypeId = this.choosenMaterialTypeId;
        let thicknessName = this.choosenThicknessName;
        this.cutModels = [];

        let regexGetThickness = /\d+([,.])?(\d+)?/g;
        let thickness = thicknessName.match(regexGetThickness) * 1000;

        this.cutModels = data.filter(function(obj) {
          let materialOK = ((obj.material_id == null) || (obj.material_id == materialId));
          let materialTypeOk = ((obj.material_type_id == null) || (obj.material_type_id == materialTypeId));
          let thicknessPart1OK = ((obj.thickness_from <= thickness) && (obj.thickness_to >= thickness));
          let thicknessPart2OK = ((obj.thickness_from <= thickness) && (obj.thickness_to == null));
          let thicknessPart3OK = ((obj.thickness_from == null) && (obj.thickness_to >= thickness));
          let thicknessPart4OK = ((obj.thickness_from == null) && (obj.thickness_to == null));
          let thicknessOk = (thicknessPart1OK || thicknessPart2OK || thicknessPart3OK || thicknessPart4OK);
          let result = (materialOK && materialTypeOk && thicknessOk);

          return result;
        }).map(function(obj) {return {id: obj.id, name: obj.name}});

        if (this.cutModels.length > 0) {
          this.choosenCutModelId = this.cutModels[0].id;
        } else {
          this.choosenCutModelId = null;
        }
      },
      serviceUnit(id) {
        for(let item in this.servicesList) {
          if (this.servicesList[item].id === id) {
            return this.servicesList[item].unit;
          }
        }
        return '?';
      },
      getChoosedGlassModel(returnCompacts){
        let data = this.glassModels.sort((a,b) => a.id - b.id);
        let materialId = this.choosenMaterialId;
        let materialTypeId = this.choosenMaterialTypeId;
        let thicknessName = this.choosenThicknessName;
        let glassMarkName = this.choosenGlassMarksName;
        let val = returnCompacts;
        let rows = [];

        let regexGetThickness = /\d+([,.])?(\d+)?/g;
        let thickness = thicknessName.match(regexGetThickness) * 1000;

        rows = data.filter(function(obj) {
          let materialOK = (obj.material_id == materialId);
          let materialTypeOK = (obj.material_type_id == materialTypeId);
          let thicknessOK = (obj.thickness == thickness);
          let glassMarkOK = (obj.glass_mark == glassMarkName);
          let validRow = (materialOK && materialTypeOK && thicknessOK && glassMarkOK);

          return validRow;
        }).map(function(obj) {
          let object = {};
          for (let i in val) {object[val[i]] = obj[val[i]];}
          return object;
        });

        return rows;
      },
      getChoosedCutModel(returnCompacts){
        let data = this.allCutModels.sort((a,b) => a.id - b.id);
        let cutModelId = this.choosenCutModelId;
        let val = returnCompacts;
        let rows = [];

        if (cutModelId === null) return false;

        rows = data.filter(function(obj) {
          let cutModelIdOK = ((obj.id*1) === cutModelId);
          return cutModelIdOK;
        }).map(function(obj) {
          let object = {};
          for (let i in val) {object[val[i]] = obj[val[i]];}
          return object;
        });

        return rows;
      },
      countOneGlassPanePrice(){},
      countGlassModelPrice(){
        let glassModelId = this.choosenGlassModelId;
        let glassModels = this.getChoosedGlassModel(['id','unit','price']);
        let glassModel = glassModels[0];
        let glassModelLoadedOk = ((glassModelId*1) === (glassModel.id*1));
        let price = 0;
        console.log('loaded');

        if (glassModelLoadedOk) {
          let multi = this.priceUnitMultiplier(glassModel.unit);
          console.log(multi);
        }
        return price;
      },
      countCutModelPrice(){},
      countHolesPrice(){},
      countServicesPrice(){},
      countAdditionalServicesPrice(){},
      priceUnitMultiplier(unit){
        let multiplier = 0;
        let width = this.glassPaneWidth;
        let height = this.glassPaneHeight;

        switch (unit) {
          case 'szt': multiplier = 1; break;
          case 'm2': multiplier = width * height / 1000000; break;
          case 'mb': multiplier = 2*(width + height) / 1000; break;
        }
        return multiplier;
      },
    },
  }
</script>
