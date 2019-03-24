<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vue - Wilayah Indonesia</title>

    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</head>
<body>
    <div id="app">
        <form v-on:submit.prevent="">
            <select v-on:change="getRegencies()" v-model="province">
                <option v-for="(item, i) in provinces" v-bind:value="item.id">
                    @{{ item.name }}
                </option>
            </select>
            <select v-on:change="getDistricts()" v-model="regency">
                <option v-for="(item, i) in regencies" v-bind:value="item.id">
                    @{{ item.name }}
                </option>
            </select>
            <select v-on:change="getVillages()" v-model="district">
                <option v-for="(item, i) in districts" v-bind:value="item.id">
                    @{{ item.name }}
                </option>
            </select>
            <select v-model="village">
                <option v-for="(item, i) in villages" v-bind:value="item.id">
                    @{{ item.name }}
                </option>
            </select>
        </form>
    </div>

    <script>
    axios.defaults.baseURL = 'http://127.0.0.1:8000/indoregion';
    var app = new Vue({
        el: '#app',
        data: {
            provinces: {},
            regencies: {},
            districts: {},
            villages: {},
            province: null,
            regency: null,
            district: null,
            village: null,
        },
        methods: {
            loadProvinces: function(){
                axios.get('/provinces').then(function(res){
                    app.provinces = res.data;
                });
            },
            getRegencies: function(){
                axios.get('/regency/'+app.province).then(function(res){
                    app.regencies = res.data;
                });
            },
            getDistricts: function(){
                axios.get('/district/'+app.regency).then(function(res){
                    app.districts = res.data;
                });
            },
            getVillages: function(){
                axios.get('/village/'+app.district).then(function(res){
                    app.villages = res.data;
                });
            }
        },
        mounted(){
            this.loadProvinces();
        }
    });
    </script>
</body>
</html>