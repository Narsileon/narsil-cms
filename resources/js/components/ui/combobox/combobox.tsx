import { Button } from "@/components/ui/button";
import { CheckIcon, ChevronsUpDownIcon } from "lucide-react";
import { cn } from "@/lib/utils";
import { SelectOption } from "@/types/global";
import { useState } from "react";
import {
  Command,
  CommandEmpty,
  CommandGroup,
  CommandInput,
  CommandItem,
  CommandList,
} from "@/components/ui/command";
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from "@/components/ui/popover";

export type ComboboxProps = {
  labelKey?: string;
  options: SelectOption[];
  value: string | number;
  valueKey?: string;
  setValue: (value: number | string) => void;
};

const Combobox = ({
  labelKey = "label",
  value,
  valueKey = "value",
  options,
  setValue,
}: ComboboxProps) => {
  const [open, setOpen] = useState(false);

  return (
    <Popover open={open} onOpenChange={setOpen}>
      <PopoverTrigger asChild>
        <Button
          className="w-[200px] justify-between"
          aria-expanded={open}
          role="combobox"
          variant="outline"
        >
          {value
            ? options.find((option) => option[valueKey] === value)?.[labelKey]
            : "Select framework..."}
          <ChevronsUpDownIcon className="ml-2 h-4 w-4 shrink-0 opacity-50" />
        </Button>
      </PopoverTrigger>
      <PopoverContent className="w-[200px] p-0">
        <Command>
          <CommandInput placeholder="Search framework..." />
          <CommandList>
            <CommandEmpty>No framework found.</CommandEmpty>
            <CommandGroup>
              {options.map((option) => (
                <CommandItem
                  value={option[valueKey]}
                  onSelect={(currentValue) => {
                    setValue(currentValue === value ? "" : currentValue);
                    setOpen(false);
                  }}
                  key={option[valueKey]}
                >
                  <CheckIcon
                    className={cn(
                      "mr-2 h-4 w-4",
                      value === option[valueKey] ? "opacity-100" : "opacity-0",
                    )}
                  />
                  {option[labelKey]}
                </CommandItem>
              ))}
            </CommandGroup>
          </CommandList>
        </Command>
      </PopoverContent>
    </Popover>
  );
};

export default Combobox;
