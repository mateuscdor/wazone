function pf(phone) {
  let phoneWa = phone.replace(/\D/g, '');

  if (phoneWa.substr(0, 2) == '08') {
    phoneWa = phoneWa.replace(/08/, '628');
  } else if (phoneWa.substr(0, 4) == '6208') {
    phoneWa = phoneWa.replace(/6208/, '628');
  } else if (phoneWa.substr(0, 2) == '52' && phoneWa.substr(2, 1) != '1') {
    phoneWa = phoneWa.replace(/52/, '521');
  } else if (phoneWa.substr(0, 2) == '54' && phoneWa.substr(2, 1) != '9') {
    phoneWa = phoneWa.replace(/54/, '549');
  } else if (phoneWa.substr(0, 2) == '55' && phoneWa.length == 13) {
    let ddd = phoneWa.substr(2, 2);
    if (
      ddd != '11' &&
      ddd != '12' &&
      ddd != '13' &&
      ddd != '14' &&
      ddd != '15' &&
      ddd != '16' &&
      ddd != '17' &&
      ddd != '18' &&
      ddd != '19' &&
      ddd != '21' &&
      ddd != '22' &&
      ddd != '24' &&
      ddd != '27' &&
      ddd != '28' &&
      ddd != '29'
    ) {
      phoneWa = '55' + ddd + phoneWa.substr(-8);
    }
  }
  return phoneWa;
}

function s_wa(phone) {
  return `${pf(phone)}@s.whatsapp.net`;
}

function g_us(phone) {
  return `${pf(phone)}@g.us`;
}

function c_us(phone) {
  return `${pf(phone)}@c.us`;
}

module.exports = { pf, s_wa, g_us, c_us };
