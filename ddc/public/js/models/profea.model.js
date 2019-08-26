////profea model
var Profea_postMdl = Model.create("Profea_postMdl");
Profea_postMdl.attributes = {
    username : "",
    userprofpic : "",
    posttime : "",
    posttext : "",
    postmedia : "",
    postlikes : 1,
    postlikepics : ["pic_url"],
    postshares : 1,
    commentnum : 1,
    postcoments : ["username","userprofpic","comment_time","comment"]
};

var car_Mdl = Model.create("car_Mdl");
car_Mdl.attributes = {
    name:"",
    model:"",
    number:0
};

var building_Mdl = Model.create("building_Mdl");
building_Mdl.attributes = {
    name: "",
    type: "",
    color:"",
    land_size: 0,
    location: ""
};