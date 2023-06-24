% Legal Aid matlab code
% --------------------------
% This code is written to provide assistance to individuals seeking legal aid 

% Initializing variables
num_clients = 0; 
num_attorneys = 0;
num_programs = 0;

% User Input
num_clients = input('Enter the number of clients in need of legal aid: ');
num_attorneys = input('Enter the number of attorneys providing legal aid: ');
num_programs = input('Enter the number of legal programs available: ' );

% Calculations
client_per_attorney = num_clients/num_attorneys;
avg_programs_per_client = num_programs/num_clients;

% Output
fprintf('The number of clients per attorney is %.2f \n', client_per_attorney)
fprintf('The average number of programs per client is %.2f \n', avg_programs_per_client)

% Create list of all clients 
client_list = []; 
for i = 1: num_clients
    client_name = input('Enter the name of the client: ', 's');
    client_list(i).name = client_name;
    client_list(i).status = "Not Assigned";
    client_list(i).assigned_attorney = 0;
end 

% Create list of all attorneys
attorney_list = [];
for i = 1: num_attorneys
    attorney_name = input('Enter the name of the attorney: ', 's');
    attorney_list(i).name = attorney_name;
    attorney_list(i).open_cases = 0;
    attorney_list(i).client_list = [];
end 

% Create list of all legal programs 
program_list = [];
for i = 1: num_programs
    program_name = input('Enter the name of the program: ', 's');
    program_list(i).name = program_name; 
    program_list(i).cost = 0;
    program_list(i).eligibility = "Not Eligible";
end

% Assign clients to attorneys 
 for i = 1: num_clients 
    min_cases = min(attorney_list.open_cases);
    if attorney_list(i).open_cases == min_cases
        attorney_list(i).open_cases = min_cases + 1;
        client_list(i).assigned_attorney = attorney_list(i).name;
        client_list(i).status = "Assigned";
        attorney_list(i).client_list(end+1) = client_list(i).name; 
    end 
end 

% Calculate program costs 
for i = 1: num_programs
    cost = input('Enter the cost of the program: '); 
    program_list(i).cost = cost;
end 

% Evaluate client eligibility
for i = 1: num_clients
    eligibility = input('Enter the eligibility of the client: ', 's');
    program_list(i).eligibility = eligibility;
end 

% Display results 
fprintf('\n Client Assignment Summary \n')
fprintf('------------------------------\n')
for i = 1: num_attorneys
    fprintf('Attorney %s has %d clients \n', attorney_list(i).name, attorney_list(i).open_cases)
    for j = 1: length(attorney_list(i).client_list) 
        fprintf('    Client %s \n', attorney_list(i).client_list(j))
    end
end 

fprintf('\n Program Eligibility Summary \n')
fprintf('--------------------------------\n')
for i = 1: num_clients 
    fprintf('Client %s is %s for the following programs \n', client_list(i).name, program_list(i).eligibility)
    for j = 1: length(program_list) 
        fprintf('    Program %s with cost %.2f \n', program_list(j).name, program_list(j).cost)
    end
end