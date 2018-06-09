class Statistiques
{
  constructor(canvas, data, ret, display)
  {
    this.canvas = canvas;
    this.ctx = this.canvas.getContext('2d');
    this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
    this.data = data;
    this.color = [
      "#f44242", "#f49542", "#f4f141", "#41f444", "#41f4e5", "#5641f4", "#f441d3",
      "#FABE58", "#26C281", "#6C7A89", "#4B77BE", "#00E640", "#9B59B6", "#D2527F"
    ];
    this.c_data = new Object();
    this.c_data.height = this.canvas.height;
    this.c_data.width = this.canvas.width;
    this.c_data.offset = $(this.canvas).offset();
    this.c_data.offsetX = this.c_data.offset.left;
    this.c_data.offsetY = this.c_data.offset.top;
    this.c_data.rect = new Array();
    this.c_data.tolerance = 10;
    this.c_data.line_width = 4;
    this.c_data.line_join = "round";
    this.ret = ret;
    this.c_data.label = this.data.label;
    this.c_data.zone_label = display[0];
    this.c_data.zone_row = display[1];
    this.c_data.zone_label.html("");
    this.c_data.zone_row.html("");
    delete this.data.label;
    this.data.max = this.get_max();
    this.canvas.echelle = (this.canvas.height / this.data.max);
  }

  find_highest_value(tab)
  {
    let tmp = 0;
    if (tab !== undefined)
      for (let i = 0; i < tab.length; i++)
        if (tab[i] > tmp)
          tmp = tab[i];
    return (tmp);
  }

  get_max()
  {
    let max = 0;
    let tmp = 0;
    for (let line in this.data)
    {
      tmp = this.find_highest_value(this.data[line].values);
      max = (tmp >= max) ? tmp : max;
    }
    return (max);
  }

  draw_curve()
  {
    let num_color = 0;
    let len = 0;
    let count = 10;
    let mult = (this.c_data.label) ? parseInt(parseInt(this.c_data.zone_label.css('width'), 10) / this.c_data.label.length, 10) : 0;
    let text = "";
    this.ctx.beginPath();
    this.ctx.fillStyle = "#636363";
    this.ctx.strokeStyle = "#636363";
    this.ctx.lineWidth = 1;
    this.ctx.moveTo(50, 0);
    this.ctx.lineTo(50, this.c_data.height);
    this.ctx.lineTo(this.c_data.width, this.c_data.height);
    this.ctx.stroke();
    this.ctx.closePath();
    this.ctx.fillText(this.data.max, 10, 10);
    this.ctx.fillText(this.data.max * 0.75, 10, (this.c_data.height * 0.25) + 10);
    this.ctx.fillText(this.data.max * 0.50, 10, (this.c_data.height * 0.50) + 10);
    this.ctx.fillText(this.data.max * 0.25, 10, (this.c_data.height * 0.75) + 10);
    this.ctx.fillText(0, 10, this.c_data.height);

    for (let i in this.c_data.label)
    {
      text = this.c_data.zone_label.html() + "<span style='position: absolute; left: " + count + "px;'>" + this.c_data.label[i] + "</span>";
      this.c_data.zone_label.html(text);
      count = count + mult;
    }

    for (let line in this.data)
    {
      if (this.data[line].values)
      {
        len = this.data[line].values.length;
        mult = Math.floor(this.c_data.width / len);
        count = 50;
        this.ctx.beginPath();
        this.ctx.lineJoin = this.c_data.line_join;
        this.ctx.lineWidth = this.c_data.line_width;
        for (let val in this.data[line].values)
        {
          this.ctx.fillStyle = this.color[num_color];
          this.ctx.strokeStyle = this.color[num_color];
          let y = (this.c_data.height - (this.data[line].values[val] * this.canvas.echelle)) + 10;
          this.ctx.lineTo(count, y);
          this.ctx.fillRect(count - 5, y - 5, 10, 10);
          this.c_data.rect[line + val] = [
            count - 5,
            y - 5,
            this.data[line].values[val]
          ];
          this.c_data.zone_label
          count = count + mult;
        }
        this.ctx.stroke();
        this.ctx.closePath();
        text = this.c_data.zone_row.html();
        text += "<div class='row-container'><span class='row_color' style='background:" + this.color[num_color] + "'></span>";
        text += "<span class='row_name'>" + line + "</span></div>";
        this.c_data.zone_row.html(text);
        num_color++;
      }
    }
    this.activate_tracking();
  }

  activate_tracking()
  {
    $(this.canvas).mousemove((e) => {
      e.preventDefault();
      e.stopPropagation();
      let mouseX = parseInt(e.clientX - this.c_data.offsetX);
      let mouseY = parseInt(e.clientY - this.c_data.offsetY);
      let active = false;

      for (let rect in this.c_data.rect)
      {
        if ((this.c_data.rect[rect][0] - mouseX <= this.c_data.tolerance && this.c_data.rect[rect][0] - mouseX >= this.c_data.tolerance * -1)
          && (this.c_data.rect[rect][1] - mouseY <= this.c_data.tolerance && this.c_data.rect[rect][1] - mouseY >= this.c_data.tolerance * -1))
        {
          this.ret.css({
            'position': 'absolute',
            'top': e.clientY - 10,
            'left': e.clientX + 10,
          }).html(this.c_data.rect[rect][2]);
          active = true;
        }
      }
      (!active) ? this.ret.css("display", "none") : this.ret.css("display", "block");
    });
  }
}
