/*****************************************************************************
TITLE: Emulator																																
AUTHOR: Anuj Sharma
ROLL NO.: 2101CS11
Declaration of Authorship
This C++ file, emu.cpp, is part of the assignment of CS209 & CS210 at the 
department of Computer Science and Engg, IIT Patna . 
*****************************************************************************/

#include <bits/stdc++.h>
using namespace std;

map<int, string> op;
void init(){
	op[0] = "ldc";
	op[1] = "adc";
	op[2] = "ldl";
	op[3] = "stl";
	op[4] = "ldnl";
	op[5] = "stnl";
	op[6] = "add";
	op[7] = "sub";
	op[8] = "shl";
	op[9] = "shr";
	op[10] = "adj";
	op[11] = "a2sp";
	op[12] = "sp2a";
	op[13] = "call";
	op[14] = "return";
	op[15] = "brz";
	op[16] = "brlz";
	op[17] = "br";
	op[18] = "HALT";
	op[-1] = "data";
	op[-2] = "SET";
}

int32_t memory[10000];
int32_t A = 0, B = 0, PC = 0, SP = 9999;

string toHex(int32_t num){
	ostringstream oss;
	int len = 8;
	oss << hex << setw(len) << setfill('0') << num;
	string ans = oss.str();
	if (len < ans.length()){
		ans = ans.substr(ans.length()-len, len);
	} 
	return ans;
}

void ISA() {
	cout << "Opcode Mnemonic Operand\n";
	cout << "       data     value\n";
	cout << "0      ldc      value\n";
	cout << "1      adc      value\n";
	cout << "2      ldl      value\n";
	cout << "3      stl      value\n";
	cout << "4      ldnl     value\n";
	cout << "5      stnl     value\n";
	cout << "6      add\n";
	cout << "7      sub\n";
	cout << "8      shl\n";
	cout << "9      shr\n";
	cout << "10     adj      value\n";
	cout << "11     a2sp\n";
	cout << "12     sp2a\n";
	cout << "13     call     offset\n";
	cout << "14     return\n";
	cout << "15     brz      offset\n";
	cout << "16     brlz     offset\n";
	cout << "17     br       offset\n";
	cout << "18     HALT\n";
	cout << "       SET      value\n";
}

void dumping(int PC, ofstream& traceFile){
	cout<<"\n\t\t---Dumping from memory---\t\t\n";
	traceFile<<"\n\t\t---Dumping from memory---\t\t\n";
	for (int i=0; i<PC; i++){
		if (i % 4){
			cout<<toHex(memory[i])<<" ";
			traceFile<<toHex(memory[i])<<" ";
		} else{
			cout<<"\n"<<toHex(i)<<"\t"<<toHex(memory[i])<<" ";
			traceFile<<"\n"<<toHex(i)<<"\t"<<toHex(memory[i])<<" ";
		}
	} cout<<endl;
}

// Function to trace individual instructions
void trace(int PC, ofstream& traceFile){
	cout<<"\n\t\t---Tracing instructions---\t\t\n\n";
	traceFile<<"\n\t\t---Tracing instruction---\t\t\n\n";

	set<int> PCoffset;
	PCoffset.insert(13); PCoffset.insert(15);
	PCoffset.insert(16); PCoffset.insert(17);

	int line = 0;

	// Loop till halt is true
	bool halt = false;
	while(true){
		int32_t instr = memory[PC];

		// for calculation of negative numbers in hexadecimal
		unsigned long hex_value = stoul("ffffffff", nullptr, 16);
		int32_t all_max = static_cast<int32_t>(hex_value);

		int maxi_op = stoi("ff", nullptr, 16);

		int32_t tmpCode = instr & 0xff;
		string tmp = toHex(tmpCode);
		tmp = tmp.substr(6, 2);

		int32_t opCode = stoi(tmp, nullptr, 16);
		if (tmp[0] >= '8'){
			opCode = -(maxi_op - opCode + 1);
		} 

		int32_t opr = instr & 0xffffff00;
		if (opr & (1<<31)){
			opr = -(all_max - opr + 1);
		}
		opr >>= 8;

		if (op.count(opCode)){
			cout << "PC: " << toHex(PC) << "\tSP: " << toHex(SP) << "\tA: " 
			<< toHex(A) << "\tB: " << toHex(B) << "\t" << op[opCode] 
			<< " " << opr << endl << endl;

			traceFile << "PC: " << toHex(PC) << "\tSP: " << toHex(SP) << "\tA: " 
			<< toHex(A) << "\tB: " << toHex(B) << "\t" << op[opCode] 
			<< " " << opr << endl << endl;
		} else{
			halt = true;
		}

		switch(opCode){
		case 0:
			B = A;
			A = opr;
			break;
		case 1:
			A += opr;
			break;
		case 2:
			B = A;
			A = memory[SP+opr];
			break;
		case 3:
			memory[SP+opr] = A;
			A = B;
			break;
		case 4:
			A = memory[A+opr];
			break;
		case 5:
			memory[A+opr] = B;
			break;
		case 6:
			A += B;
			break;
		case 7:
			A = B - A;
			break;
		case 8:
			A = B << A;
			break;
		case 9:
			A = B >> A;
			break;
		case 10:
			SP += opr;
			break;
		case 11:
			SP = A;
			A = B;
			break;
		case 12:
			B = A;
			A = SP;
			break;
		case 13:
			B = A;
			A = PC;
			PC += opr;
			break;
		case 14:
			if (PC == A && A == B) halt = true;
			PC = A;
			A = B;
			break;
		case 15:
			if(A == 0){
				PC += opr;
			}
			break;
		case 16:
			if(A < 0){
				PC += opr;
			}
			break;
		case 17:
			PC += opr;
			break;
		case 18:
			halt = true;
			break;
		} 
		if (SP >= 10000){
			cout<<"SP exceeding the memory at PC: "<<PC<<endl;
			halt = true;
		}
		if (PCoffset.count(opCode) && opr == -1){
			cout<<"Infinite loop detected"<<endl;
			halt = true;
		} 
		if (halt) break;
		PC++;
		line++;
	}
	cout<<line<<" number of instructions executed!"<<endl;
}

int main(int argc, char* argv[]){
	if (argc < 3){
		cout<<"Usage: ./emu [option] file.o"<<endl;
		cout<<"Where [option] is one of the following:"<<endl;
		cout<<"\t-trace : Show trace of the executed instruction."<<endl;
		cout<<"\t-before : Show memory dump before program execution."<<endl;
		cout<<"\t-after : Show memory dump after program execution."<<endl;
		cout << "\t-isa\tdisplay ISA" << endl;
		return 0;
	}

	init();

	string inFile = string(argv[2]);

	string traceFile = inFile.substr(0, inFile.find('.')) + ".trace";

	ifstream input(inFile, ios::out | ios::binary);
	ofstream output(traceFile);

	string text;
	getline(input, text);
	if (!text.length()) return 0;

	int line = 0;

	// for calculation of negative numbers in hexadecimal
	int maxi_opr = stoi("ffffff", nullptr, 16);
	int maxi_op = stoi("ff", nullptr, 16);

	for (int start = 0; start < text.length(); start += 8){
		string macCode = text.substr(start, 8);
		unsigned long hex_value = stoul(macCode, nullptr, 16);
		int32_t instr = static_cast<int32_t>(hex_value);

		string tmp = macCode.substr(6, macCode.length());
		int32_t opCode = stoi(tmp, nullptr, 16);
		if (tmp[0] >= '8'){
			opCode = -(maxi_op - opCode + 1);
		}

		tmp = macCode.substr(0, 6);
		int32_t opr = stoi(tmp, nullptr, 16);
		if (tmp[0] >= '8'){
			opr = -(maxi_opr - opr + 1);
		}

		if (opCode < 0){
			memory[line] = opr;
		} else {
			memory[line] = instr;
		}
		line++;
	}

	// Dumping before execution
	if(string(argv[1]) == "-before"){
		dumping(line, output);
	}

	// Tracing each instruction
	if(string(argv[1]) == "-trace"){
		trace(PC, output);
	}

	// Dumping after execution
	if(string(argv[1]) == "-after"){
		trace(PC, output);
		dumping(line, output);
	}

	return 0;
}