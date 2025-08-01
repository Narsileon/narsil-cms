// https://ui.shadcn.com/docs/components/combobox

import { Button } from "@narsil-cms/components/ui/button";
import { CheckIcon, ChevronsUpDownIcon } from "lucide-react";
import { cn, getSelectOption } from "@narsil-cms/lib/utils";
import { lowerCase } from "lodash";
import { useLabels } from "@narsil-cms/components/ui/labels";
import { useState } from "react";
import {
  Command,
  CommandEmpty,
  CommandGroup,
  CommandInput,
  CommandItem,
  CommandList,
} from "@narsil-cms/components/ui/command";
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from "@narsil-cms/components/ui/popover";
import type { SelectOption } from "@narsil-cms/types/forms";
import type { UniqueIdentifier } from "@dnd-kit/core";

type ComboboxProps = {
  className?: string;
  disabled?: boolean;
  id?: string;
  labelPath?: string;
  options: SelectOption[] | string[];
  placeholder?: string;
  search?: boolean;
  value: UniqueIdentifier;
  valuePath?: string;
  renderOption?: (value: SelectOption | string) => React.ReactNode;
  setValue: (value: string) => void;
};

function Combobox({
  className,
  disabled,
  id,
  labelPath = "label",
  placeholder,
  search = true,
  value,
  valuePath = "value",
  options,
  renderOption,
  setValue,
}: ComboboxProps) {
  const { getLabel } = useLabels();

  const [open, setOpen] = useState(false);

  const option = options.find((option) => {
    const optionValue = getSelectOption(option, valuePath);

    return optionValue == value;
  });

  function filter(value: string, search: string) {
    const option = options?.find((option) => {
      return (
        getSelectOption(option, valuePath) == value ||
        getSelectOption(option, labelPath) == value
      );
    });

    if (option) {
      const optionLabel = getSelectOption(option, labelPath);

      if (lowerCase(optionLabel).includes(lowerCase(search))) {
        return 1;
      }
    }

    return 0;
  }

  return (
    <Popover open={open} onOpenChange={setOpen} modal={true}>
      <PopoverTrigger asChild={true}>
        <Button
          id={id}
          className={cn(
            "w-full justify-between font-normal",
            !option && "text-muted-foreground",
            className,
          )}
          aria-expanded={open}
          disabled={disabled}
          role="combobox"
          variant="outline"
        >
          {option
            ? getSelectOption(option, labelPath)
            : (placeholder ?? "Search...")}
          <ChevronsUpDownIcon className="ml-2 size-5 shrink-0" />
        </Button>
      </PopoverTrigger>
      <PopoverContent className="w-[200px] p-0">
        <Command filter={filter}>
          {search ? (
            <CommandInput placeholder={placeholder ?? "Search..."} />
          ) : null}
          <CommandList>
            <CommandEmpty>{getLabel("pagination.empty")}</CommandEmpty>
            <CommandGroup>
              {options.map((option) => {
                const optionLabel = getSelectOption(option, labelPath);
                const optionValue = getSelectOption(option, valuePath);

                return (
                  <CommandItem
                    value={optionValue.toString()}
                    onSelect={(currentValue) => {
                      setValue(currentValue == value ? "" : currentValue);
                      setOpen(false);
                    }}
                    key={optionValue}
                  >
                    <CheckIcon
                      className={cn(
                        "mr-2 h-4 w-4",
                        value == optionValue ? "opacity-100" : "opacity-0",
                      )}
                    />
                    {renderOption ? renderOption(option) : optionLabel}
                  </CommandItem>
                );
              })}
            </CommandGroup>
          </CommandList>
        </Command>
      </PopoverContent>
    </Popover>
  );
}

export default Combobox;
