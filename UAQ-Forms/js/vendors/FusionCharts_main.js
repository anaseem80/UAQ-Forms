const dataSource = {
    chart: {
      caption: "Co-working Locations of WeWork in Different Countries",
      nullentityfillcolor: "#757DE8",
      showmarkerlabels: "0",
      showentitytooltip: "0",
      showentityhovereffect: "0",
      theme: "fusion"
    },
    markers: {
      items: [
        {
          id: "lon",
          shapeid: "we-anchor",
          x: "190.23",
          y: "350.9",
          label: "Chile",
          value: "1",
          tooltext: "In Chile, WeWork has <b>$value</b> co-working location"
        },
        {
          id: "atl",
          shapeid: "we-anchor",
          x: "130.14",
          y: "140.9",
          label: "USA",
          value: "25",
          tooltext: "In USA, WeWork has <b>$value</b> co-working locations</b>",
          labelpos: "left"
        },
        {
          id: "ind",
          shapeid: "we-anchor",
          x: "500.14",
          y: "203.9",
          label: "India",
          value: "3",
          tooltext: "In India, WeWork has <b>$value</b> co-working locations",
          labelpos: "bottom"
        },
        {
          id: "Aus",
          shapeid: "we-anchor",
          x: "628.14",
          y: "305.9",
          label: "Autralia",
          value: "3",
          tooltext: "In Australia, WeWork has <b>$value</b> co-working locations"
        },
        {
          id: "china",
          shapeid: "we-anchor",
          x: "573.14",
          y: "161.9",
          label: "China",
          value: "6",
          tooltext: "In China, WeWork has <b>$value</b> co-working locations"
        },
        {
          id: "Thi",
          shapeid: "we-anchor",
          x: "553.14",
          y: "211.9",
          label: "Thailand",
          value: "1",
          tooltext: "In Thailand, WeWork has <b>$value</b> co-working location"
        },
        {
          id: "Sing",
          shapeid: "we-anchor",
          x: "560.14",
          y: "231.9",
          label: "Singapore",
          value: "1",
          tooltext: "In Singapore, WeWork has <b>$value</b> co-working location"
        },
        {
          id: "Indo",
          shapeid: "we-anchor",
          x: "570.14",
          y: "250.9",
          label: "Indonesia",
          value: "1",
          tooltext: "In Indonesia, WeWork has <b>$value</b> co-working location"
        },
        {
          id: "sKorea",
          shapeid: "we-anchor",
          x: "603.14",
          y: "155.9",
          label: "South Korea",
          value: "1",
          tooltext: "In South Korea, WeWork has <b>$value</b> co-working location"
        },
        {
          id: "jap",
          shapeid: "we-anchor",
          x: "633.14",
          y: "145.9",
          label: "Japan",
          value: "1",
          tooltext: "In Japan, WeWork has <b>$value</b> co-working location"
        },
        {
          id: "isrl",
          shapeid: "we-anchor",
          x: "445.14",
          y: "165.9",
          label: "Isreal",
          value: "5",
          tooltext: "In Israel, WeWork has <b>$value</b> co-working locations"
        },
        {
          id: "ire",
          shapeid: "we-anchor",
          x: "325.14",
          y: "105.9",
          label: "Ireland",
          value: "1",
          tooltext: "In Ireland, WeWork has <b>$value</b> co-working location",
          labelpos: "left"
        },
        {
          id: "pol",
          shapeid: "we-anchor",
          x: "365.14",
          y: "118.9",
          label: "Poland",
          value: "1",
          tooltext: "In Poland, WeWork has <b>$value</b> co-working location"
        },
        {
          id: "spain",
          shapeid: "we-anchor",
          x: "330.14",
          y: "145.9",
          label: "Spain",
          value: "2",
          tooltext: "In Spain, WeWork has <b>$value</b> co-working locations"
        },
        {
          id: "Mexico",
          shapeid: "we-anchor",
          x: "130.14",
          y: "190.9",
          label: "Mexico",
          value: "1",
          tooltext: "In Mexico, WeWork has <b>$value</b> co-working location"
        },
        {
          id: "Brazil",
          shapeid: "we-anchor",
          x: "250.14",
          y: "260.9",
          label: "Brazil",
          value: "3",
          tooltext: "In Brazil, WeWork has <b>$value</b> co-working locations"
        }
      ],
      shapes: [
        {
          id: "we-anchor",
          type: "image",
          url:
            "https://cdn3.iconfinder.com/data/icons/iconic-1/32/map_pin_fill-512.png",
          xscale: "4",
          yscale: "4"
        }
      ]
    }
  };
  
  FusionCharts.ready(function() {
    var myChart = new FusionCharts({
      type: "world",
      renderAt: "chart-container",
      width: "100%",
      height: "100%",
      dataFormat: "json",
      dataSource
    }).render();
  });
  