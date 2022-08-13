"use strict";Object.defineProperty(exports,"__esModule",{value:true});var _baileys=require("../../Baileys");var _chat=require("../chat");function asyncGeneratorStep(gen,resolve,reject,_next,_throw,key,arg){try{var info=gen[key](arg);var value=info.value}catch(error){reject(error);return}if(info.done){resolve(value)}else{Promise.resolve(value).then(_next,_throw)}}function _asyncToGenerator(fn){return function(){var self=this,args=arguments;return new Promise(function(resolve,reject){var gen=fn.apply(self,args);function _next(value){asyncGeneratorStep(gen,resolve,reject,_next,_throw,"next",value)}function _throw(err){asyncGeneratorStep(gen,resolve,reject,_next,_throw,"throw",err)}_next(undefined)})}}class Message{constructor(src){let key=src.key;this.raw=src;this.id=key.id;this.isMe=key.fromMe;this.from=(0,_baileys).jidNormalizedUser(key.remoteJid);this.sender=(0,_baileys).jidNormalizedUser(key.participant||key.remoteJid);this.senderName=src.pushName;this.me=undefined;this.chat=undefined;var _messageTimestamp;this.timestamp=(_messageTimestamp=src.messageTimestamp)!==null&&_messageTimestamp!==void 0?_messageTimestamp:-1;this.receipt=src.userReceipt}}exports.Message=Message;Message.prototype.isValid=function isValid(){if(isNaN(this.timestamp))return false;if(this.me===undefined)return false;if(this.chat===undefined)return false;return true};Message.prototype.onRead=function onRead(cb){if(this.me===undefined){console.dir(this,{depth:null});throw new Error("Message class not initialized completely. Please report bug.")}var _this=this;this.me.sock.ws.on(`TAG:${this.id}`,function(){var _ref=_asyncToGenerator(function*(node){if((node.attrs.class||node.tag)!=="receipt"||node.attrs.type!=="read")return;let readerJid=(0,_baileys).jidNormalizedUser(node.attrs.participant||node.attrs.from);let chatJid=(0,_baileys).jidNormalizedUser(node.attrs.to||node.attrs.from);let reader=new _chat.Chat;reader.name="";reader.id=readerJid;reader.me=_this.me;let chat;if((0,_baileys).isJidUser(chatJid)){chat=reader}else if((0,_baileys).isJidGroup(chatJid)){chat=yield _chat.Group.fromJid(_this.me.sock,chatJid);chat.me=_this.me}let detail={reader,chat,timestamp:Date.now()};cb(detail)});return function(node){return _ref.apply(this,arguments)}}())};Message.prototype.react=function(){var _react=_asyncToGenerator(function*(reaction){reaction=reaction||"";yield this.me._send((0,_baileys).jidNormalizedUser(this.chat.id),{react:{text:reaction,key:this.raw.key}})});function react(reaction){return _react.apply(this,arguments)}return react}()