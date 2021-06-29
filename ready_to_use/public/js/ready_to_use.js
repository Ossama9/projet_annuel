import * as THREE from "./three.module.js";
import { FBXLoader } from "./FBXLoader.js";
import { OrbitControls } from "./OrbitControls.js";
import { TextureLoader } from "./TextureLoader.js";
import { FontLoader } from "./FontLoader.js";


let camera, scene, renderer, clock, mixer, delta;
let loadingManager, textureLoader, fbxLoader, objLoader;

function createCardboardFactory(){

    fbxLoader.load( "./assets/objects/small-conveyor-belt-scene/conveyer build.fbx", function ( object ) {

        object.scale.set( 0.01, 0.01, 0.01 );
        object.position.set( 0, -10, 6 );

        mixer = new THREE.AnimationMixer( object );
        let action = mixer.clipAction( object.animations[ 2 ] );
        action.play();

        object.traverse( function ( child ) {

            if( child.name == "Spot"){
                child.intensity = 0.7;
            }

            if ( child.isMesh ) {

                child.castShadow = true;
                child.receiveShadow = true;
            }
        } );

        scene.add( object );

    });
}


function addReadyToUseLogo(){
    
    let logo = new THREE.MeshBasicMaterial( { map: new THREE.TextureLoader().load("./assets/images/logo.PNG") } );
    //logo.map.needsUpdate = true;

    let planeLeft = new THREE.Mesh( new THREE.PlaneGeometry(1, 1), logo );
    planeLeft.rotation.y = 1.60;
    planeLeft.scale.set( 2, 2, 2 );
    planeLeft.position.set( 2.45, -2, 12.5 );


    let logo_invert = new THREE.MeshBasicMaterial( { map: new THREE.TextureLoader().load("./assets/images/logo_invert.PNG") } );

    let planeRight = new THREE.Mesh( new THREE.PlaneGeometry(1, 1), logo_invert );
    planeRight.rotation.y = 1.60;
    planeRight.scale.set( 2, 2, 2 );
    planeRight.position.set( 2.45, -2, -12 );


    scene.add( planeLeft, planeRight );
}


function addTitle(){

    const fontLoader = new FontLoader();

    fontLoader.load( "./assets/font/optimer_bold.typeface.json", function ( font ) {
        let textGeo = new THREE.TextGeometry( "Commande en cours de préparation", {
            font: font,
            size: 20,
            height: 20,
            curveSegments: 5,
            bevelEnabled: true,
            bevelThickness: 2,
            bevelSize: 1.5,
            bevelOffset: 0,
            bevelSegments: 5
        } );

        textGeo.computeBoundingBox();

        let textMaterial = new THREE.MeshPhongMaterial( { color: 0x1ac8d9 } );

        let text = new THREE.Mesh( textGeo, textMaterial );
        text.rotation.y = 1.60;
        text.scale.set( 0.05, 0.05, 0.05 );
        text.position.set( -4, 3.5, 11.5)

        scene.add(text);
    } );
    
}


function redir(){
    self.location.href="https://www.google.fr";
}


function manageLoading() {
    loadingManager = new THREE.LoadingManager();

    fbxLoader = new FBXLoader( loadingManager );

    let loader = document.getElementById( "loader" );

    loadingManager.onLoad = function ( ) {
        loader.style.display = "none";

        //setTimeout(redir,21500);
    }
}


function init() {

    renderer = new THREE.WebGLRenderer( { antialias: true } );
    renderer.setPixelRatio( window.devicePixelRatio );
    renderer.setSize( window.innerWidth, window.innerHeight );
    document.body.appendChild( renderer.domElement );

    //shadow initialisation
    renderer.shadowMap.enabled = true;
    renderer.shadowMap.type = THREE.PCFSoftShadowMap;

    scene = new THREE.Scene();

    camera = new THREE.PerspectiveCamera( 7.5, window.innerWidth / window.innerHeight, 1, 500 );
    camera.position.set( 120, 26, 0 );

    const ambientLight = new THREE.AmbientLight( 0xcccccc, 0.5 );
    scene.add( ambientLight );

    window.addEventListener( "resize", onWindowResize );

    //initiation of global variable
    clock = new THREE.Clock();

    manageLoading();
    createCardboardFactory();
    addReadyToUseLogo();
    addTitle();

    var controls = new OrbitControls(camera, renderer.domElement);
}


function onWindowResize() {

    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();

    renderer.setSize( window.innerWidth, window.innerHeight );
}


function animate() {

    requestAnimationFrame( animate );

    delta = clock.getDelta();

    if ( mixer ) 
        mixer.update( delta );

    renderer.render( scene, camera );
}

init();
animate();