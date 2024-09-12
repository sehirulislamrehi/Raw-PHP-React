const getAllServices = (state = false, action) => {

     if( action.type == "getAllServices" ){
          return action.response;
     }
     else{
          return state;
     }

};

export default getAllServices;