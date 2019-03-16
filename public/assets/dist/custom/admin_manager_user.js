$('#sidebar-manager-user').addClass('active');
// Configuration
const loadTimeInterval = 200;
const assets = $("meta[name='assets']").attr("content");
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.baseURL = $("meta[name='api']").attr("content");
// Jquery
// Vue Instance
var app = new Vue({
    el: '#app',
    data: {
        table: null,
        filter: 'admin',
        nama: '',
        username: '',
        email: '',
        password: '',
        avatar: '',
        showChangeAvatar: false,
        id: 0,
    },
    methods: {
        loadStart(){
            NProgress.start();
            NProgress.set(0.4);
        },
        loadDone(){
            setTimeout(function(){NProgress.done();}, loadTimeInterval);
        },
        loadTable(){
            if (app ===  undefined) { this.loadStart(); } else { app.loadStart(); }
            $('#users-table').dataTable().fnDestroy();
            this.table = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '',
                    data: { filter: this.filter },
                    error: function (jqXHR, textStatus, errorThrown) {
                    if (app ===  undefined) { this.loadDone(); } else { app.loadDone(); }
                        if (jqXHR.status == 500) {
                            alertify.error('Server error, Try again later');
                        } else {
                            alertify.error('['+jqXHR.status+'] Error : '+'['+ejqXHR.statusText+']');
                        }
                    }
                },
                columns: [
                    {data: 'no'},
                    {data: 'id'},
                    {data: 'nama'},
                    {data: 'username'},
                    {data: 'email', searchable: true},
                    {data: 'action', orderable: false, searchable: false},
                ],
                responsive: true,
                drawCallback: function( settings ) {
                    app.loadDone();
                },
            });
            $('#users-table').on( 'search.dt', function (e, settings) {
                if (app ===  undefined) { this.loadStart(); } else { app.loadStart(); }
            });
        },
        refreshTable(){
            this.table.ajax.reload( null, false );
        },
        detail(id){
            this.loadStart();
            axios.post('', {action: 'detail', 'id': id}).then(function(res){
                if (res.data.status == 'success') {
                    let user = res.data.result;
                    let avatar = (user.avatar === null ? assets + '/dist/img/avatar.png' : assets + "/images/100x100/" + user.avatar.path);
                    let html = "<div class='row'><div class='col-3'><div class='avatar'><img src='"+avatar+"' alt='...' class='img-fluid rounded-circle'></div></div><div class='col-8'><table><tr><td><b>ID</b></td><td> : "+user.id+"</td></tr><tr><td><b>Nama</b></td><td> : "+user.nama+"</td></tr><tr><td><b>Email</b></td><td> : "+user.email+"</td></tr><tr><td><b>Username</b></td><td> : "+user.username+"</td></tr><tr><td><b>Created at</b></td><td> : "+user.created_at+"</td></tr></table></div></div>";
                    alertify.alert('Detail User', html); 
                }
                app.loadDone();
            }).catch(function(error){
                error = error.response;
                app.loadDone();
                app.handleCatch(error);
            });
        },
        edit(id) {
            this.loadStart();
            axios.post('', {action: 'detail', 'id': id}).then(function(res){
                let user = res.data.result;
                app.password = '';
                app.email = user.email;
                app.username = user.username;
                app.nama = user.nama;
                app.id = user.id;
                app.avatar = (user.avatar === null ? assets + '/dist/img/avatar.png' : assets + "/images/100x100/" + user.avatar.path);
                $('#modalEdit').modal('show');
                app.loadDone();
            }).catch(function(error){
                error = error.response;
                app.loadDone();
                app.handleCatch(error);
            });
        },
        delete(id, username) {
            let html = '<div style="text-align: center;">Yakin Akan Menghapus @' + username + '?</div>';
            alertify.confirm('Konfirmasi', html, function(){
                app.loadStart();
                axios.post('', {action: 'delete', 'id': id}).then(function(res){
                    if (res.data.status == 'success') {
                        alertify.success('Berhasil menghapus');
                    }
                    app.refreshTable();
                    app.loadDone();
                }).catch(function(error){
                    error = error.response;
                    app.loadDone();
                    app.handleCatch(error);
                });
            },function(){
            }).set({labels:{ok:'Hapus', cancel: 'Batal'}});
        },
        addNew(){
            var params = {
                action: 'addnew',
                nama: app.nama,
                username: app.username,
                email: app.email,
                password: app.password,
                role: app.filter
            };

            this.loadStart();
            axios.post('', params).then(function(res){
                app.loadDone();
                if (res.data.status == 'success') {
                    alertify.success('User berhasil dibuat');
                    app.refreshTable();
                } else {
                    alertify.error('User gagal dibuat');
                }
            }).catch(function(error){
                error = error.response;
                app.loadDone();
                if (error.status == 422 && error.statusText == "Unprocessable Entity"){
                    let errors  = error.data.errors;
                    Object.keys(errors).map(function(item, index){
                        alertify.error(errors[item][0]);
                    });
                } else { app.handleCatch(error); }
            });

            app.password = '';
            app.email = '';
            app.username = '';
            app.nama = '';
            app.id = '';
        },
        handleCatch(error) {
            app.loadDone();
            if (error.status == 500) {
                alertify.error('Server Error, Try again later');
            } else if (error.status == 422) {
                alertify.error('Form invalid, Check input form');
            } else {
                alertify.error('['+error.response.status+'] Error : '+'['+error.response.statusText+']');
            }
        },
        update() {
            var params = {
                action: 'update',
                nama: app.nama,
                username: app.username,
                email: app.email,
                password: app.password,
                id: app.id,
            };

            this.loadStart();
            axios.post('', params).then(function(res){
                app.loadDone();
                if (res.data.status == 'success') {
                    alertify.success('@'+res.data.result.username+' berhasil diperbarui');
                    app.refreshTable();
                } else {
                    alertify.error('@'+res.data.result.username+' gagal diperbarui');
                }
            }).catch(function(error){
                error = error.response;
                app.loadDone();
                if (error.status == 422 && error.statusText == "Unprocessable Entity"){
                    let errors  = error.data.errors;
                    Object.keys(errors).map(function(item, index){
                        alertify.error(errors[item][0]);
                    });
                } else { app.handleCatch(error); }
            });
        },
        generateSafePassword() {
            // var specials = '!@#$%^&*()_+{}:"<>?\|[];\',./`~';
            var lowercase = 'abcdefghijklmnopqrstuvwxyz';
            var uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            var numbers = '0123456789';
            var all = lowercase + uppercase + numbers;
            String.prototype.pick = function(min, max) {
                var n, chars = '';
                if (typeof max === 'undefined') {
                    n = min;
                } else {
                    n = min + Math.floor(Math.random() * (max - min));
                }
                for (var i = 0; i < n; i++) {
                    chars += this.charAt(Math.floor(Math.random() * this.length));
                }
                return chars;
            };
            String.prototype.shuffle = function() {
                var array = this.split('');
                var tmp, current, top = array.length;
                if (top) while (--top) {
                    current = Math.floor(Math.random() * (top + 1));
                    tmp = array[current];
                    array[current] = array[top];
                    array[top] = tmp;
                }
                return array.join('');    
            };
            var password = (lowercase.pick(1) + uppercase.pick(1) + all.pick(3, 10)).shuffle();
            this.password = password;
        }
    },
    mounted(){
        this.loadTable();
    }
});