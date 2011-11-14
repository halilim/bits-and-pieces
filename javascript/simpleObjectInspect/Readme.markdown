Javascript Simple Object Inspect
==================================

	console.log(simpleObjInspect(var));
	
Displays type and value of the var. If it's something like a hash table, it also displays keys and values of its members recursively.
Useful when console.log is not available or it's not sufficient for what you need. Kind of var_dump for javascript (a bit more verbose, e.g. includes types of keys).