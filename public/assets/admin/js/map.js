
mapboxgl.accessToken = 'pk.eyJ1IjoieHVhbnBob25nMDkiLCJhIjoiY20yaXJreWhkMDFlYzJqcXR4MHNqbHc2aCJ9.sfY1bJbQMnBUemqu9nLKdw';
var map = new mapboxgl.Map({
    container: 'map', // ID của thẻ chứa bản đồ
    style: 'mapbox://styles/xuanphong09/cm2isc2jb00bm01pea2iah9ej', // Style URL từ Mapbox Studio
    center: [105.933972, 21.00807], // Tọa độ trung tâm
    zoom: 16, // Mức zoom ban đầu
    pitch: 50, // Góc nghiêng của bản đồ (dùng cho 3D)
    bearing: -91, // Hướng quay của bản đồ (để tạo góc nhìn 3D hợp lý)
    antialias: true // Làm mịn hình ảnh, giúp hiển thị 3D rõ hơn
});

// chuyen doi giua 2D va 3D
var is3D = true;
document.getElementById('toggleView').addEventListener('click', function () {
    if (is3D) {
        // Chuyển sang 2D
        map.easeTo({
            pitch: 0, // Góc nghiêng 0 cho 2D
            bearing: -80, // Quay về hướng mặc định
            duration: 1000 // Thời gian chuyển đổi (ms)
        });
        this.textContent = "3D";
    } else {
        // Chuyển sang 3D
        map.easeTo({
            pitch: 60, // Góc nghiêng 60 độ cho 3D
            bearing: -80, // Hướng quay phù hợp cho góc nhìn 3D
            duration: 1000
        });
        this.textContent = "2D";
    }
    is3D = !is3D;
});

map.on('load', function () {
    // Tạo một Polygon lớn bao quanh toàn bộ khu vực bản đồ (masking area)
    var outerBoundary = [
        [
            [105.8, 20.9], // Một tọa độ rất xa để bao quanh bản đồ
            [106.0, 20.9],
            [106.0, 21.1],
            [105.8, 21.1],
            [105.8, 20.9]
        ]
    ];

    // Tọa độ của vùng ranh giới bạn muốn hiển thị (inner boundary)
    var innerBoundary = [
        [
            [105.9303977834607, 20.99937152821748],
            [105.93572739328988, 20.99888173353355],
            [105.93590458800503, 20.99958752095779],
            [105.93729201399057, 20.99951421228438],
            [105.93949144855392, 21.001073213828242],
            [105.93832341495109, 21.002092396422285],
            [105.93691178708326, 21.003022592025793],
            [105.93719623679038, 21.003512400016213],
            [105.93753364177053, 21.003893446925865],
            [105.9370774720183, 21.003990037607245],
            [105.93736588966844, 21.004963366715558],
            [105.93412899111442, 21.005445853597415],
            [105.93425612647918, 21.00627694248037],
            [105.9342662720909, 21.006342650091806],
            [105.93395220702757, 21.006389717737],
            [105.93404686981648, 21.006967700803656],
            [105.93327879495106, 21.007284698546936],
            [105.93343272693174, 21.00764129127171],
            [105.93407903781534, 21.007332359989526],
            [105.9354647495347, 21.006779133997934],
            [105.93584467154533, 21.007506190992032],
            [105.93496872574636, 21.007908995844378],
            [105.93553533729137, 21.008994977194952],
            [105.9344659683617, 21.009484442120222],
            [105.9344631616344, 21.00971703374367],
            [105.93464767981249, 21.010231996397685],
            [105.93535365699802, 21.011210239962132],
            [105.93627128033987, 21.013453281711442],
            [105.93639903211115, 21.014158822861333],
            [105.93563629526781, 21.01400803881942],
            [105.93565449385176, 21.01535314750508],
            [105.93588170415686, 21.01721691959358],
            [105.9365901115473, 21.020716687706447],
            [105.930215614947, 21.020167549267796],
            [105.92598746273282, 21.01971080396799],
            [105.92646196570148, 21.01476029168254],
            [105.92727554833047, 21.01416731745978],
            [105.92809126618188, 21.013280883689394],
            [105.92860958291652, 21.011700393076403],
            [105.92910240734031, 21.009165570522022],
            [105.9295952317641, 21.00663074796764],
            [105.92984673444118, 21.004164999133685],
            [105.92888444564248, 21.001075365140576],
            [105.93003389129754, 20.99986673725261],
            [105.93042360825586, 20.999388859333294]
        ]
    ];

    // Thêm nguồn GeoJSON với 2 Polygon: 1 lớn bao quanh và 1 nhỏ bên trong
    map.addSource('mask', {
        'type': 'geojson',
        'data': {
            'type': 'Feature',
            'geometry': {
                'type': 'Polygon',
                'coordinates': [
                    outerBoundary[0], // Polygon bao quanh lớn
                    innerBoundary[0]  // Polygon bên trong (vùng được hiển thị)
                ]
            }
        }
    });

    // Thêm lớp phủ polygon với fill để tạo masking
    map.addLayer({
        'id': 'mask-layer',
        'type': 'fill',
        'source': 'mask',
        'layout': {},
        'paint': {
            'fill-color': '#000', // Màu đen cho vùng bị che
            'fill-opacity': 0.5 // Độ mờ của vùng bị che (0.5 nghĩa là trong suốt 50%)
        }
    });
});
var labeledPoints = {
    'type': 'FeatureCollection',
    'features': points.map(point => ({
        'type': 'Feature',
        'geometry': {
            'type': 'Point',
            'coordinates': [point.longitude, point.latitude],
        },
        'properties': {
            'name': point.name,
            'icon': point.icon_name,
            'description': point.description,
            'thumbnail': point.thumbnail
        },
        'id': point.id
    }))
};

map.on('load', function () {
    // Duyệt qua các icon và tải chúng vào Mapbox
    icons.forEach(icon => {
        const imagePath = "/storage/" + icon.thumbnail;
        map.loadImage(imagePath, function (error, image) {
            if (error) throw error;
            map.addImage(icon.name, image);
        });
    });

    // Thêm nguồn dữ liệu chứa điểm với icon và nhãn
    map.addSource('labeled-points-with-icons', {
        'type': 'geojson',
        'data': labeledPoints
    });

    // Thêm lớp biểu tượng
    map.addLayer({
        'id': 'icon-labels',
        'type': 'symbol',
        'source': 'labeled-points-with-icons',
        'layout': {
            'icon-image': ['get', 'icon'], // Sử dụng thuộc tính 'icon' để chỉ định biểu tượng
            'icon-size': 0.6, // Kích thước của icon
            'text-field': ['step', ['zoom'], '', 17, ['get', 'name']], // Lấy thuộc tính 'name' để hiển thị nhãn
            'text-size': 12, // Kích thước của nhãn
            'text-anchor': 'top', // Định vị nhãn ở phía trên icon
            'text-offset': [0, 1.5], // Đặt khoảng cách giữa nhãn và biểu tượng
            'icon-allow-overlap': true, // Cho phép các icon chồng lên nhau nếu cần
            'text-allow-overlap': true // Cho phép các nhãn chồng lên nhau nếu cần
        },
        'paint': {
            'text-color': '#000000' // Màu của nhãn (đen)
        },
        'minzoom': 15, // Mức zoom tối thiểu để hiển thị vùng sáng (chỉnh giá trị theo nhu cầu)
        'maxzoom': 20  // Mức zoom tối đa (nếu cần)
    });
});
// Thêm sự kiện click vào bản đồ
map.on('click', (e) => {
    const coordinates = e.lngLat;

    // Kiểm tra xem có điểm nào tại vị trí nhấp hay không
    const features = map.queryRenderedFeatures(e.point, {
        layers: ['icon-labels'] // Lớp chứa các điểm của bạn
    });

    if (features.length) {
        // Nếu điểm đã tồn tại, hiển thị popup với thông tin chi tiết
        const pointData = features[0].properties;

        // Tạo URL chỉ đường với tọa độ
        var coordinate = features[0].geometry.coordinates;
        var directionsUrl = `https://www.google.com/maps/dir/?api=1&destination=${coordinate[1]},${coordinate[0]}`;
        var thumbnail = '../storage/' + pointData.thumbnail;
        const finalEditPointUrl = editPointUrl.replace(':id', features[0].id);
        new mapboxgl.Popup({ className: 'fixed-popup' })
            .setLngLat(coordinates)
            .setHTML(`
                <h6 class="mb-1">${pointData.name}</h6>
                <img src="${thumbnail}"  alt="${pointData.name}" class="mb-1" style="width: 98%; height: 100px; object-fit: cover">

                <span style="margin:5px 0;font-size: 14px">${pointData.description}</span><br>
                <a href="${directionsUrl}" target="_blank" style="color:blue; font-size: 14px;">Chỉ đường đến đây</a>
                <br>
                <a href="${finalEditPointUrl}" class="btn btn-teal">Sửa</a>
                <button wire:click="openDeleteModelPoint(${features[0].id})" class="btn btn-danger">Xóa</button>
<!--                <a href="http://127.0.0.1:8000/admin/map/${features[0].id}" class="btn btn-danger">Xóa</a>-->
            `)
            .addTo(map);
    } else {
        // Nếu điểm chưa tồn tại, hiển thị popup để tạo điểm mới
        new mapboxgl.Popup()
            .setLngLat(coordinates)
            .setHTML(`
                <h6>Điểm chưa được đánh dấu.</h6>
                <a href="${createPointUrl}?lng=${coordinates.lng}&lat=${coordinates.lat}" class="btn btn-teal">Thêm mới</a>
            `)
            .addTo(map);
    }

    // Đổi con trỏ thành dạng bàn tay khi di chuột qua điểm
    map.on('mouseenter', 'icon-labels', function () {
        map.getCanvas().style.cursor = 'pointer';
    });

// Đổi lại con trỏ thành bình thường khi rời khỏi điểm
    map.on('mouseleave', 'icon-labels', function () {
        map.getCanvas().style.cursor = '';
    });
});

map.on('load', function () {
    map.addSource('label', {
        type: 'geojson',
        data: {
            type: 'FeatureCollection',
            features: [{
                type: 'Feature',
                geometry: {
                    type: 'Point',
                    coordinates: [105.93119287697698,21.009199011617724] // Điền tọa độ của Học viện NN Việt Nam
                },
                properties: {
                    title: 'Học viện Nông nghiệp Việt Nam'
                }
            }]
        }
    });

    // Thêm một layer hiển thị dòng chữ với điều kiện mức zoom
    map.addLayer({
        id: 'label_vnua',
        type: 'symbol',
        source: 'label',
        layout: {
            'text-field': ['step', ['zoom'], '', 13, ['get', 'title'], 15, ''],
            'text-size': 24,
            'text-anchor': 'top',
            'visibility': 'visible',
            'text-max-width': 40
        },
        paint: {
            'text-color': '#171717',
            'text-halo-color': '#ffffff',     // Màu viền (trắng)
            'text-halo-width': 2,             // Độ dày viền
            'text-halo-blur': 0.3               // Độ mờ viền
        }
    });
});




