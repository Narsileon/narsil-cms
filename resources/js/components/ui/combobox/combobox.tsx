// https://ui.shadcn.com/docs/components/combobox

import { Button } from "@/components/ui/button";
import { CheckIcon, ChevronsUpDownIcon } from "lucide-react";
import { cn } from "@/lib/utils";
import { get, isString, lowerCase } from "lodash";
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
  options: SelectOption[] | string[];
  value: string | number;
  valueKey?: string;
  setValue: (value: number | string) => void;
};

function getSelectOptionLabel(
  option: SelectOption | string,
  labelKey: string,
): string {
  const label = isString(option) ? option : get(option, labelKey);

  return label;
}

function getSelectOptionValue(
  option: SelectOption | string,
  valueKey: string,
): any {
  const value = isString(option) ? option : get(option, valueKey);

  return value;
}

const Combobox = ({
  labelKey = "label",
  value,
  valueKey = "value",
  options,
  setValue,
}: ComboboxProps) => {
  const [open, setOpen] = useState(false);

  const option = options.find((option) => {
    const optionValue = getSelectOptionValue(option, valueKey);

    return optionValue === value;
  });

  function filter(value: string, search: string) {
    const option = options?.find((option) => {
      return (
        getSelectOptionValue(option, valueKey) === value ||
        getSelectOptionLabel(option, labelKey) === value
      );
    });

    if (option) {
      const optionLabel = getSelectOptionLabel(option, labelKey);

      if (lowerCase(optionLabel).includes(lowerCase(search))) {
        return 1;
      }
    }

    return 0;
  }

  return (
    <Popover open={open} onOpenChange={setOpen}>
      <PopoverTrigger asChild>
        <Button
          className="w-[180px] justify-between"
          aria-expanded={open}
          role="combobox"
          variant="outline"
        >
          {option
            ? getSelectOptionLabel(option, labelKey)
            : "Select framework..."}
          <ChevronsUpDownIcon className="ml-2 h-4 w-4 shrink-0 opacity-50" />
        </Button>
      </PopoverTrigger>
      <PopoverContent className="w-[200px] p-0">
        <Command filter={filter}>
          <CommandInput placeholder="Search framework..." />
          <CommandList>
            <CommandEmpty>No framework found.</CommandEmpty>
            <CommandGroup>
              {options.map((option) => {
                const optionLabel = getSelectOptionLabel(option, labelKey);
                const optionValue = getSelectOptionValue(option, valueKey);

                return (
                  <CommandItem
                    value={optionValue}
                    onSelect={(currentValue) => {
                      setValue(currentValue === value ? "" : currentValue);
                      setOpen(false);
                    }}
                    key={optionValue}
                  >
                    <CheckIcon
                      className={cn(
                        "mr-2 h-4 w-4",
                        value === optionValue ? "opacity-100" : "opacity-0",
                      )}
                    />
                    {optionLabel}
                  </CommandItem>
                );
              })}
            </CommandGroup>
          </CommandList>
        </Command>
      </PopoverContent>
    </Popover>
  );
};

export default Combobox;
