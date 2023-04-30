#include <stdio.h>
#define JTAG_UART_BASE 0xFF201000
/* This files provides address values that exist in the system */

#define BOARD "DE1-SoC"

/* Memory */
#define DDR_BASE 0x00000000
#define DDR_END 0x3FFFFFFF
#define A9_ONCHIP_BASE 0xFFFF0000
#define A9_ONCHIP_END 0xFFFFFFFF
#define SDRAM_BASE 0xC0000000
#define SDRAM_END 0xC3FFFFFF
#define FPGA_ONCHIP_BASE 0xC8000000
#define FPGA_ONCHIP_END 0xC803FFFF
#define FPGA_CHAR_BASE 0xC9000000
#define FPGA_CHAR_END 0xC9001FFF

/* Cyclone V FPGA devices */
#define LEDR_BASE 0xFF200000
#define HEX3_HEX0_BASE 0xFF200020
#define HEX5_HEX4_BASE 0xFF200030
#define SW_BASE 0xFF200040
#define KEY_BASE 0xFF200050
#define JP1_BASE 0xFF200060
#define JP2_BASE 0xFF200070
#define PS2_BASE 0xFF200100
#define PS2_DUAL_BASE 0xFF200108
#define JTAG_UART_BASE 0xFF201000
#define JTAG_UART_2_BASE 0xFF201008
#define IrDA_BASE 0xFF201020
#define TIMER_BASE 0xFF202000
#define AV_CONFIG_BASE 0xFF203000
#define PIXEL_BUF_CTRL_BASE 0xFF203020
#define CHAR_BUF_CTRL_BASE 0xFF203030
#define AUDIO_BASE 0xFF203040
#define VIDEO_IN_BASE 0xFF203060
#define ADC_BASE 0xFF204000

/* Cyclone V HPS devices */
#define HPS_GPIO1_BASE 0xFF709000
#define HPS_TIMER0_BASE 0xFFC08000
#define HPS_TIMER1_BASE 0xFFC09000
#define HPS_TIMER2_BASE 0xFFD00000
#define HPS_TIMER3_BASE 0xFFD01000
#define FPGA_BRIDGE 0xFFD0501C

/* ARM A9 MPCORE devices */
#define PERIPH_BASE 0xFFFEC000		 // base address of peripheral devices
#define MPCORE_PRIV_TIMER 0xFFFEC600 // PERIPH_BASE + 0x0600

/* Interrupt controller (GIC) CPU interface(s) */
#define MPCORE_GIC_CPUIF 0xFFFEC100 // PERIPH_BASE + 0x100
#define ICCICR 0x00					// offset to CPU interface control reg
#define ICCPMR 0x04					// offset to interrupt priority mask reg
#define ICCIAR 0x0C					// offset to interrupt acknowledge reg
#define ICCEOIR 0x10				// offset to end of interrupt reg
/* Interrupt controller (GIC) distributor interface(s) */
#define MPCORE_GIC_DIST 0xFFFED000		   // PERIPH_BASE + 0x1000
#define ICDDCR 0x00						   // offset to distributor control reg
#define ICDISER 0x100					   // offset to interrupt set-enable regs
#define ICDICER 0x180					   // offset to interrupt clear-enable regs
#define ICDIPTR 0x800					   // offset to interrupt processor targets regs
#define ICDICFR 0xC00					   // offset to interrupt configuration regs


#define G     77
#define A     88
#define B     99
#define C     75
#define D     76
#define E     78
#define F     80
#define REST  0

volatile int *KEY_PTR = (int *)0xFF200050; // address of the input register

int score=0;
char seg7[10] =	{0b00111111, 0b00000110, 0b01011011, 0b01001111, 0b01100110, 
						 0b01101101, 0b01111101, 0b00000111, 0b01111111, 0b01100111};


char get_jtag(volatile int *JTAG_UART_ptr){
	int data;
	data = *(JTAG_UART_ptr);
	if (data & 0x00008000) // check RVALID
		return ((char)data & 0xFF);
	else
		return ('\0');
}


volatile int* audio_dev = (int*) 0xff203040; 

void play_note(int freq, int duration) {
    int counter;
    int status_reg;
    duration = duration * 100;
    int sample_value = 0x7fffffff;
    while (duration--) {
        // Wait for available write space
        do {
            status_reg = *((volatile int *)(audio_dev + 1));
        } while ((status_reg & 0xff00) == 0 || (status_reg & 0xff) == 0);

        // Write two audio samples
        counter = freq;
        while (counter--) {
            *((volatile int *)(audio_dev + 2)) = sample_value;
            *((volatile int *)(audio_dev + 3)) = sample_value;
        }

        // Invert waveform
        sample_value = ~sample_value + 1;
    }
}

void write_pixel(int x, int y, short colour){
	volatile short *vga_addr = (volatile short *)(0x08000000 + (y << 10) + (x << 1));
	*vga_addr = colour;
	
}

void write_char(int x, int y, char c) {
  volatile char * character_buffer = (char *) (0x09000000 + (y<<7) + x);
  *character_buffer = c;
}

void colour_screen(short colour){
	clear_char();
	int x, y;
	for (x = 0; x < 320; x++)
	{
		for (y = 0; y < 240; y++)
		{
			write_pixel(x, y, colour);
			
		}
	}
}

void box( int x,int y){
	for(int i=x;i<x+30;i++)
		for(int j=y;j<y+40;j++)
		write_pixel(i,j,0);
	
}
void box_line(int x,int y){
	for(int i=x;i<x+30;i++)
		for(int j=y;j<y+1;j++)
		write_pixel(i,j,0);
	
}

void clear_box(int x,int y){
	for(int i=x;i<x+30;i++)
		for(int j=y;j<y+1;j++)
		 write_pixel(i,j,0x7f3e);
}


void clear_box_entire(int x,int y){
	for(int i=x;i<x+30;i++)
		for(int j=y;j<y+40;j++)
		 write_pixel(i,j,0x7f3e);
}

void clear_portion(int x,int y){
	for(int i=0;i<240;i++)
		for(int j=x;j<y;j++)
		 write_pixel(j,i,0x7f3e);
}

void partition(){
	for(int i=0;i<240;i++){
		write_pixel(80,i,0xFFFF);
		write_pixel(160,i,0xFFFF);
		write_pixel(240,i,0xFFFF);
	}
}

void points(){
   	score+=5;
	volatile int * HEX3_HEX0_ptr = (int *) HEX3_HEX0_BASE;
	volatile int * HEX5_HEX4_ptr = (int *) HEX5_HEX4_BASE;
	
	    *HEX5_HEX4_ptr = seg7[score/100000] << 8;
		*HEX5_HEX4_ptr |= seg7[(score/10000)%10];

		*HEX3_HEX0_ptr = seg7[(score/1000)%10] << 24;
		*HEX3_HEX0_ptr |= seg7[(score/100)%10] << 16;

		*HEX3_HEX0_ptr |= seg7[(score/10)%10] << 8;
		*HEX3_HEX0_ptr |= seg7[score%10];
}

void move_box(int x,int key,int note,int duration){
 	volatile int *JTAG_UART_ptr = (int *)0xFF201000;
	int flag=0;
	key+=96;
   for(int i=0;i<40;i++)
	{
	   	box_line(x,i);
		for(int i=0;i<100000;i++);
	}
	for(int i=40;i<240;i++)
	    {  
        	char c = get_jtag(JTAG_UART_ptr);

	     	if(c==key){
				flag=1;
				play_note(note,duration);
				points();
			}

			clear_box(x,i-40);
			box_line(x,i);
			for(int i=0;i<80000;i++);	

        	if(flag==1)
			{
			 clear_box_entire(x,i-39);
   			 break;
			}
        }
    
    	for(int i=200;i<240;i++)
		{
	   		clear_box(x,i);
			for(int i=0;i<100000;i++);
		}
		
		char c = get_jtag(JTAG_UART_ptr);
	while(c!=0) c = get_jtag(JTAG_UART_ptr);                     
}

// Define constants for note size and position
#define NOTE_WIDTH 10
#define NOTE_HEIGHT 20
#define NOTE_X 140
#define NOTE_Y 20 // position the note near the top of the screen

// Define function to draw a filled circle
void draw_circle(int cx, int cy, int r, short colour) {
    int x, y;
    for (y = cy-r; y <= cy+r; y++) {
        for (x = cx-r; x <= cx+r; x++) {
             if ((x-cx)*(x-cx) + (y-cy)*(y-cy) < r*r){
                write_pixel(x, y, colour);
			 }
        }
    }
}

// Draw the musical note
void draw_note1(int sx, int sy) {
    int x, y;

    // Draw stem
    for (y = NOTE_Y - sy; y < NOTE_Y + NOTE_HEIGHT - sy; y++) {
		for (x = NOTE_X + NOTE_WIDTH - 1 - sx; x<=NOTE_X+NOTE_WIDTH - sx; x++){
			write_pixel(x, y, 0x03C0); // peacock blue
		}
    }

    // Draw note head
    draw_circle(NOTE_X + NOTE_WIDTH/2 - sx, NOTE_Y - sy, NOTE_WIDTH/2, 0x03C0); // peacock blue
}

void draw_note2(int sx, int sy) {
    int x, y;

    // Draw stem
    for (y = NOTE_Y - sy; y < NOTE_Y + NOTE_HEIGHT - sy; y++) {
		write_pixel(NOTE_X - NOTE_WIDTH+10 - sx, y, 0x03C0); // peacock blue
		write_pixel(NOTE_X - NOTE_WIDTH+11 - sx, y, 0x03C0); // peacock blue
    }

    // Draw note head
    draw_circle(NOTE_X + NOTE_WIDTH/2 - sx, NOTE_Y - sy, NOTE_WIDTH/2, 0x03C0); // peacock blue
}

void start_game(){
	colour_screen(0x0000);
	draw_note1(42, -100);
	draw_note2(-73, -100);
	int x, y;
	for (x = 5; x<=315; x++){
		write_pixel(x, 5, 0xffff);
		write_pixel(x, 235, 0xffff);
	}
	for (x = 8; x<=312; x++){
		write_pixel(x, 8, 0xffff);
		write_pixel(x, 232, 0xffff);
	}
	for (y = 5; y<=235; y++){
		write_pixel(5, y, 0xffff);
		write_pixel(315, y, 0xffff);
	}
	char* name = "Welcome to Musical Tiles!";
	x = 28;
	while(*name){
		write_char(x, 30, *name);
		x++;
		name++;
	}
	
	char* archi = "MiniProject II";
	x = 34;
	while(*archi){
		write_char(x, 15, *archi);
		x++;
		archi++;
	}
	
	int start_shift_up = 0;
	char* hw = "Start game";
	x = 35;
 	while (*hw) {
		write_char(x, 40 - start_shift_up/3, *hw);
		x++;
		hw++;
	}
	
	for (x=137; x<=183; x++){
       write_pixel(x, 157 - start_shift_up, 0xf800);
	   write_pixel(x, 165 - start_shift_up, 0xf800);
   	}
	for (y=157 - start_shift_up; y<=165 - start_shift_up; y++){
		write_pixel(137, y, 0xf800);
		write_pixel(183, y, 0xf800);
	}
}

void game_over(){
	colour_screen(0x0000);
	draw_note1(42, -100);
	draw_note2(-73, -100);
	int x, y;
	for (x = 5; x<=315; x++){
		write_pixel(x, 5, 0xffff);
		write_pixel(x, 235, 0xffff);
	}
	for (x = 8; x<=312; x++){
		write_pixel(x, 8, 0xffff);
		write_pixel(x, 232, 0xffff);
	}
	for (y = 5; y<=235; y++){
		write_pixel(5, y, 0xffff);
		write_pixel(315, y, 0xffff);
	}
	char* name = "Game Over";
	x = 35;
	while(*name){
		write_char(x, 30, *name);
		x++;
		name++;
	}
}

void clear_char() {
	for (int x = 0; x<80; x++){
		for (int y=0; y<60; y++){
  			volatile char * character_buffer = (char *) (0x09000000 + (y<<7) + x);
  			*character_buffer = '\0';
		}
	}
}

int main(){
	volatile int * KEYS_ptr = (int *) KEY_BASE;
	int edge_capture;
	int flag = 0;

while(1){
		start_game();
		while(1){
			edge_capture = *(KEYS_ptr+3);				// read the KEYs edge capture register
			if (edge_capture){
				*(KEYS_ptr+3) = edge_capture;			// clear edge capture register
				flag ^= 1;
				break;
			}
		}
		if (flag == 1){
			clear_char();
			colour_screen(0x7f3e);
			partition();
			score=-5;
			points();
			int melody[20] = { E,E,E,E,E,E,E,G,C,D,E,E,D,D,D,G,G,F,E,E};
			int duration[20]={200,200,400,200,200,400,200,200,200,400,400,200,200,400,200,200,200,200,400,200};
			//  printf("%d",sizeof(duration)/sizeof(duration[0]));
			for(int i=0;i<20;i++){
			    int dur=duration[i];
			    if(melody[i]==C) move_box(25,1,A,dur);
			    else if(melody[i]==D) move_box(105,19,D,dur);
			    else if(melody[i]==E) move_box(185,4,E,dur);
			    else move_box(265,6,G,dur);
				for(int i=0;i<100000;i++);
			}
			game_over();
			while(1){
				edge_capture = *(KEYS_ptr+3);				// read the KEYs edge capture register
				if (edge_capture){
					*(KEYS_ptr+3) = edge_capture;			// clear edge capture register
					flag ^= 1;
					break;
				}
			}
		}
}

}
