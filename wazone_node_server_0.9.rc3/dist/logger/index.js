"use strict";Object.defineProperty(exports,"__esModule",{value:true});exports.default=makeLogger;var _pino=_interopRequireDefault(require("pino"));function makeLogger(ev,config){let destination={write(str){let json=JSON.parse(str);ev.emit("logs",json)}};const logger=(0,_pino).default({level:"trace"},destination);return logger}function _interopRequireDefault(obj){return obj&&obj.__esModule?obj:{default:obj}}