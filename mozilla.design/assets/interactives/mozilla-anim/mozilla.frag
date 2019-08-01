#ifdef GL_ES
precision highp float;
#endif

#define PI_TWO			1.570796326794897
#define PI				3.141592653589793
#define TWO_PI			6.283185307179586
#define GOLDEN			1.61803
#define INV_GOLDEN		0.61803

uniform vec2 u_resolution;
uniform vec2 u_mouse;
uniform vec2 u_mouse_accumulator;
uniform vec2 u_mouse_delta;
uniform float u_time;

float rand(vec2 st) {
	return fract(sin(dot(st.xy, vec2(12.9898,78.233)))*43758.5453123);
}

float slice(float x, float min, float max) {
	return step(min, x) * step(x, max);
}

vec3 rgb2hsv(vec3 c) {
	vec4 K = vec4(0.0, -1.0 / 3.0, 2.0 / 3.0, -1.0);
	vec4 p = mix(vec4(c.bg, K.wz), vec4(c.gb, K.xy), step(c.b, c.g));
	vec4 q = mix(vec4(p.xyw, c.r), vec4(c.r, p.yzx), step(p.x, c.r));

	float d = q.x - min(q.w, q.y);
	float e = 1.0e-10;
	return vec3(abs(q.z + (q.w - q.y) / (6.0 * d + e)), d / (q.x + e), q.x);
}
vec3 hsv2rgb(vec3 c) {
	vec4 K = vec4(1.0, 2.0 / 3.0, 1.0 / 3.0, 3.0);
	vec3 p = abs(fract(c.xxx + K.xyz) * 6.0 - K.www);
	return c.z * mix(K.xxx, clamp(p - K.xxx, 0.0, 1.0), c.y);
}

#define DIGITAL_NAVY vec3(0.0863, 0.1255, 0.4314)
#define DIGITAL_MIN_COL 80.0
#define DIGITAL_MAX_COL 180.0
vec3 glitch_digital(vec2 st, vec2 translate, float time) {
	float rnd = rand(st);
	float rndy = rand(st.yy);
	float width = DIGITAL_MAX_COL * rndy + DIGITAL_MIN_COL;
	// float iloc = floor(st.x / width);
	float floc = fract((st.x - rndy * DIGITAL_MAX_COL + (time * 15.0 * rndy + translate.x * 20.0) * rndy * 10.0) / width);
	vec3 hsv = vec3(
		fract(rndy + st.x / 500.0 + rnd / 20.0),
		1.0,
		clamp(floc, rndy, 0.8)
	);
	return mix(hsv2rgb(hsv), DIGITAL_NAVY, mod(st.x,2.0)); // odd column out
}

vec3 glitch_smear(vec2 st, vec2 translate, float time) {
	st.y += time * 3.0 + translate.y * 10.0;
	float rnd = rand(st);
	float rndy = rand(st.yy);
	
	
	float a = pow(fract(st.y * 0.05), 10.0) * 15.0;
	float line_shift = mod(st.y * 0.4, 15.0 + a) * 1.8 + rndy * 2.0;
	st.x -= line_shift - translate.x * 2.0;
	
	float col_shift = pow(fract(st.x * 0.05), 10.0) * 0.7;
	float mask = step(0.5, fract(st.x / 85.0 + rnd * 0.1) + col_shift) * step(rnd, 0.95);
	vec3 color = hsv2rgb(vec3(
		fract(st.x / 50.0 + col_shift) * 0.15,
		fract(st.x * 0.14 * rnd) + 0.2,
		mask - fract(st.x / 50.0 + col_shift) * 0.5
	));
	float magnetic_noise = pow(fract(st.x * 0.075), 5.0) * 0.86;
	vec3 noise_color = hsv2rgb(vec3(
		(rndy * 0.25) + 0.375,
		magnetic_noise * 2.0,
		magnetic_noise * rndy + rnd * 0.4
	));
	color = mix(noise_color, color, color);
	return color;
}
vec3 glitch_rgb(vec2 st, vec2 translate, float time) {
	float hshift = sin(floor(st.y / TWO_PI));
	vec2 _st = st;
	_st.x += translate.x + hshift * 4.0;
	
	vec3 odd_3 = vec3(step(1.0, mod((_st.x + 1.0) * 0.333, 2.0)));
	vec3 odd_6 = 1.0 - vec3(step(1.0, mod(_st.x, 6.0)));
	vec3 rgb_cols = vec3(1.0 - step(1.0, mod(_st.x, 3.0)), 1.0 - step(1.0, mod(_st.x + 1.0, 3.0)), 1.0 - step(1.0, mod(_st.x + 2.0, 3.0)));
	vec3 glitch_cols = vec3(
		step(1.0, mod(_st.x + 0.0, 3.0)) * (rand(_st) * 0.5 + 0.5),
		rand(st + 1.0),
		rand(st + 3.0)
	) * 0.5;
	// return glitch_cols;
	return rgb_cols * odd_3 + glitch_cols * odd_6;
}

vec3 uniform_color_noise(vec2 st, float time) {
	return vec3(rand(st + time), rand(st + time + 1.0), rand(st + time + 2.0));
}
float uniform_bw_noise(vec2 st, float time) {
	return rand(st + time);
}
float noise_mask(vec2 st, vec2 dimensions, float time, float threshold) {
	float rnd = rand(st.yy + time);
	float rnd2 = rand(st + time);
	return step(threshold, rnd) * slice(st.x, rnd2 * dimensions.x, dimensions.x);
}

#define PIXEL_SIZE 2.0
void main() {
	vec2 uv = gl_FragCoord.xy / u_resolution.xy;
	
	// Scale the coordinates when your drawing buffer is 1:1 pixel
	vec2 st_s = gl_FragCoord.xy; // vec2 st_s = gl_FragCoord.xy / PIXEL_SIZE;
	vec2 res_s = u_resolution.xy; // vec2 res_s = u_resolution.xy / PIXEL_SIZE;
	vec2 ipos = floor(st_s);
	// vec2 fpos = fract(st_s);
	
	float time = mod(u_time, 100.0);
	vec2 mouse_translate = u_mouse / u_resolution * 2.0;
	vec2 mouse_accumulator_translate = u_mouse_accumulator / u_resolution * 2.0;
	
	#define MPEG_GLITCH_BLOCK_SIZE 8.0
	#define MPEG_GLITCH_BLOCK_DEFAULT_THRESHOLD 0.9995
	#define MPEG_GLITCH_BLOCK_MAX_AMPLIFY 0.008
	#define MPEG_GLITCH_LINE_DEFAULT_THRESHOLD 0.995
	#define MPEG_GLITCH_LINE_MAX_AMPLIFY 0.02

	vec2 mpeg_block = floor(gl_FragCoord.xy / MPEG_GLITCH_BLOCK_SIZE);
	float slow_time = time / 250000.0;
	float mpeg_block_rnd = rand(mpeg_block + slow_time);
	float mpeg_line_rnd = rand(mpeg_block.yy + slow_time);
	float mpeg_offset = sign(mpeg_block_rnd - 0.5) * MPEG_GLITCH_BLOCK_SIZE;
	float mpeg_block_mask = step(MPEG_GLITCH_BLOCK_DEFAULT_THRESHOLD - (min(MPEG_GLITCH_BLOCK_MAX_AMPLIFY, dot(u_mouse_delta.x, u_mouse_delta.y))), mpeg_block_rnd);
	float mpeg_line_mask = step(MPEG_GLITCH_LINE_DEFAULT_THRESHOLD - (min(MPEG_GLITCH_LINE_MAX_AMPLIFY, dot(u_mouse_delta.x, u_mouse_delta.y))), mpeg_line_rnd);
	float mpeg_mask = clamp(mpeg_block_mask + mpeg_line_mask, 0.0, 1.0);
	vec2 ipos_glitched = ipos + mpeg_offset * mpeg_mask;
	// <- mpeg glitch discoloration continued later...

	float digital_mask = slice(ipos_glitched.y, INV_GOLDEN*res_s.y, 1.0*res_s.y) + slice(ipos_glitched.y, 0.25*res_s.y, 0.32*res_s.y);
	vec3 color = glitch_digital(ipos_glitched, mouse_accumulator_translate, time) * digital_mask;

	#define SMEAR_NOISE_FEATHER 0.015
	#define SMEAR_HEIGHT ((1.0 - INV_GOLDEN) * INV_GOLDEN)
	#define SMEAR_Y (1.0 - INV_GOLDEN - SMEAR_NOISE_FEATHER)
	
	float smear_noise = noise_mask(ipos, res_s, time*0.001, 0.005);
	vec3 smear = glitch_smear(ipos_glitched, vec2(mouse_translate.x, mouse_accumulator_translate.y), time);
	float smear_mask = slice(ipos_glitched.y, SMEAR_Y*res_s.y, (SMEAR_Y+SMEAR_HEIGHT)*res_s.y);
	smear_mask += smear_noise * (pow(fract(ipos_glitched.y/res_s.y/SMEAR_NOISE_FEATHER),0.2) * slice(ipos_glitched.y, (SMEAR_Y-SMEAR_NOISE_FEATHER)*res_s.y, SMEAR_Y*res_s.y));
	smear_mask += smear_noise * (pow(fract(ipos_glitched.y/res_s.y/SMEAR_NOISE_FEATHER),0.2) * slice(ipos_glitched.y, (SMEAR_Y+SMEAR_HEIGHT)*res_s.y, (SMEAR_Y+SMEAR_HEIGHT+SMEAR_NOISE_FEATHER)*res_s.y));
	color += smear * smear_mask;
	
	color += glitch_rgb(ipos_glitched, mouse_translate, time) * slice(ipos_glitched.y, 0.0, 0.125*res_s.y);

	float noise_thresh = 1.0 - (pow(fract(time * 100.0), 3.0) * 0.014 + (abs(u_mouse_delta.x) + abs(u_mouse_delta.y)) * 0.0005);
	color += noise_mask(ipos, res_s, time / 15000.0, noise_thresh) * uniform_color_noise(ipos, time) * 0.65;
	
	color = rgb2hsv(color);
	color.z -= 0.2;
	color.y += 0.15;
	color = hsv2rgb(color);
	
	color *= clamp(pow(uv.y * 5.0, 2.0), 0.1, 1.0); // darken the bottom to make text more visible

	// mpeg discoloration
	#define MPEG_COLOR_SHIFT_COEFFICIENT vec3(2.5, 0.5, 2.5)
	vec3 original_color = color;
	color *= MPEG_COLOR_SHIFT_COEFFICIENT * mpeg_mask;
	color += original_color * (1.0 - mpeg_mask);
	
	gl_FragColor = vec4(color, 1.0);
}