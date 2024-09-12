const getAllArea = (state = false, action) => {
     if( action.type == "getAllArea" ){
          return action.response;
     }
     else{
          return state;
     }
}

export default getAllArea;