"use strict";Object.defineProperty(exports,"__esModule",{value:true});exports.array_remove_index=array_remove_index;function array_remove_index(array,index){let a=array.splice(index);a.shift();for(const i of a){array.push(i)}}