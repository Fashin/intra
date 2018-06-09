let key = "*z6g4-1654g65z4g65zr4g65z4g6zgnkjyhqs#wnjkjngh";

let encrypt = (value) => {
  while (key.length < value.length)
    key = key + key;
  let current = 0;
  let result = "";
  let crypted;
  while (current < value.length)
  {
    crypted = value.charCodeAt(current) + key.charCodeAt(current);
    if (crypted > 127)
      crypted = crypted - 127;
    result = result + String.fromCharCode(crypted);
    current = current + 1;
  }
  return (result);
};

let decrypt = (value) => {
  while (key.length < value.length)
    key = key + key;
  let current = 0;
  let result = "";
  let uncrypt;
  while (current < value.length)
  {
    uncrypt = value.charCodeAt(current) - key.charCodeAt(current);
    if (uncrypt < 0)
      uncrypt = uncrypt + 127;
    result = result + String.fromCharCode(uncrypt);
    current = current + 1;
  }
  return (result);
};
