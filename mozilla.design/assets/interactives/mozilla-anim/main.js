let requestAnimationFrameHandle = null;
let gl = null;
let vbo = null;

let loadTime = null;
let canvasVisible = false;
const lastMouseLoc = {x: -1, y: -1};
const mouseDelta = {x: 0, y: 0};
const mouseAccumulator = {x: 0, y: 0};

const vert_str = `
#ifdef GL_ES
precision mediump float;
#endif

attribute vec2 a_position;

void main() {
	gl_Position = vec4(a_position, 0.0, 1.0);
}
`;

const gl_attrs = {
	a_position: null,
};
const gl_uniforms = {
	u_resolution: null,
	u_mouse: null,
	u_mouse_accumulator: null,
	u_mouse_delta: null,
	u_time: null
};

function init() {
	const canvas = document.getElementById('canvas');
	if(!canvas) throw new Error('Canvas not found.');

	gl = canvas.getContext('webgl') || canvas.getContext('experimental-webgl');
	if(!gl) throw new Error('Unable to initialize WebGL.');
	
	// Add a fallback image:
	// const fallbackImage = document.getElementById('glFallback');
	// if(!fallbackImage) throw new Error('Fallback image not found.');
	// if(!gl) fallbackImage.style.display = 'initial';

	// Build shaders
	const vertexShader = gl.createShader(gl.VERTEX_SHADER);
	if(!vertexShader) throw new Error('Could not create vertex shader.');
	gl.shaderSource(vertexShader, vert_str);
	gl.compileShader(vertexShader);
	const vertCompiled = gl.getShaderParameter(vertexShader, gl.COMPILE_STATUS);
	if(!vertCompiled) throw new Error(gl.getShaderInfoLog(vertexShader));
	
	const fragmentShader = gl.createShader(gl.FRAGMENT_SHADER);
	if(!fragmentShader) throw new Error('Could not create fragment shader.');
	gl.shaderSource(fragmentShader, frag_str);
	gl.compileShader(fragmentShader);
	const fragCompiled = gl.getShaderParameter(fragmentShader, gl.COMPILE_STATUS);
	if(!fragCompiled) throw new Error(gl.getShaderInfoLog(fragmentShader));
	
	const program = gl.createProgram();
	if(!program) throw new Error('Could not create program.');
	gl.attachShader(program, vertexShader);
	gl.attachShader(program, fragmentShader);
	gl.linkProgram(program);
	
	Object.keys(gl_attrs).forEach((attr) => {
		gl_attrs[attr] = gl.getAttribLocation(program, attr);
	});
	
	Object.keys(gl_uniforms).forEach((uniform) => {
		const ul = gl.getUniformLocation(program, uniform);
		if(!ul) throw new Error(`Could not find uniform location: ${uniform}.`);
		gl_uniforms[uniform] = ul;
	});
	
	// Drawable square
	vbo = gl.createBuffer();
	gl.bindBuffer(gl.ARRAY_BUFFER, vbo);
	gl.bufferData(gl.ARRAY_BUFFER, new Float32Array([-1.0, -1.0, 1.0, -1.0, -1.0, 1.0, -1.0, 1.0, 1.0, -1.0, 1.0, 1.0]), gl.STATIC_DRAW);
	gl.enableVertexAttribArray(gl_attrs.a_position);
	gl.vertexAttribPointer(gl_attrs.a_position, 2, gl.FLOAT, false, 0, 0);
	
	// Init GL
	gl.useProgram(program);
	gl.clearColor(0.0, 0.0, 0.0, 0.0);
	gl.disable(gl.DEPTH_TEST);
	gl.disable(gl.BLEND);

	loadTime = performance.now();
	window.addEventListener('mousemove', handleMouseMove);
	window.addEventListener('scroll', handleScroll);
	window.addEventListener('resize', handleResize);
	handleResize();
	handleScroll(); // kicks off rendering
}

function handleResize() {
	const rect = gl.canvas.getBoundingClientRect();
	gl.canvas.width = rect.width / 2;
	gl.canvas.height = rect.height / 2;
	gl.viewport(0, 0, gl.drawingBufferWidth, gl.drawingBufferHeight);
}

function render() {
	gl.uniform2f(gl_uniforms.u_resolution, gl.canvas.width, gl.canvas.height);
	gl.uniform2f(gl_uniforms.u_mouse, lastMouseLoc.x, lastMouseLoc.y);
	gl.uniform2f(gl_uniforms.u_mouse_accumulator, mouseAccumulator.x, mouseAccumulator.y);
	gl.uniform2f(gl_uniforms.u_mouse_delta, mouseDelta.x, mouseDelta.y);
	gl.uniform1f(gl_uniforms.u_time, (performance.now() - loadTime) / 1000.0);
	// Smoothly reduce mouseDelta to ensure that it diminishes even when we're not receiving mouse events
	// (e.g. the cursor has left the browser)
	mouseDelta.x *= 0.5;
	mouseDelta.y *= 0.5;
	
	gl.clear(gl.COLOR_BUFFER_BIT);
	gl.viewport(0, 0, gl.canvas.width, gl.canvas.height);
	gl.bindBuffer(gl.ARRAY_BUFFER, vbo);
	gl.drawArrays(gl.TRIANGLES, 0, 6);
	
	requestAnimationFrameHandle = requestAnimationFrame(render);
}


function handleMouseMove(event) {
	// relative to canvas, converted to GL-coordinates (origin bottom-left)
	const canvasRect = gl.canvas.getBoundingClientRect();
	const relative_x = event.clientX - canvasRect.x;
	const relative_y = window.innerHeight - event.clientY - canvasRect.y;
	mouseDelta.x = relative_x - lastMouseLoc.x;
	mouseDelta.y = relative_y - lastMouseLoc.y;
	lastMouseLoc.x = relative_x;
	lastMouseLoc.y = relative_y;
	mouseAccumulator.x += Math.abs(mouseDelta.x);
	mouseAccumulator.y += Math.abs(mouseDelta.y);
}

function canvasInViewport() {
	const rect = gl.canvas.getBoundingClientRect();
	return (rect.bottom >= 0 && rect.right >= 0 && rect.top <= (window.innerHeight || document.documentElement.clientHeight) && rect.left <= (window.innerWidth || document.documentElement.clientWidth));
}

function handleScroll() {
	const old = canvasVisible;
	canvasVisible = canvasInViewport();
	if(!old && canvasVisible) {
		requestAnimationFrameHandle = requestAnimationFrame(render);
	} else if(!canvasVisible && requestAnimationFrameHandle !== null) {
		cancelAnimationFrame(requestAnimationFrameHandle);
		requestAnimationFrameHandle = null;
	}
}
