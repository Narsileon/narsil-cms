import * as React from "react";
import { Button } from "@narsil-cms/components/ui/button";
import { cn, getSelectOption } from "@narsil-cms/lib/utils";
import { Icon } from "@narsil-cms/components/ui/icon";
import { isString, lowerCase } from "lodash";
import { useLabels } from "@narsil-cms/components/ui/labels";
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

  const [open, setOpen] = React.useState(false);

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
            "bg-input/25 w-full justify-between font-normal",
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
            : (placeholder ?? getLabel("placeholders.search"))}
          <Icon
            className={cn("ml-2 shrink-0 duration-200", open && "rotate-180")}
            name="chevron-down"
          />
        </Button>
      </PopoverTrigger>
      <PopoverContent className="w-[200px] p-0">
        <Command filter={filter}>
          {search ? (
            <CommandInput
              placeholder={placeholder ?? getLabel("placeholders.search")}
            />
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
                    <Icon
                      className={cn(
                        "size-4",
                        value == optionValue ? "opacity-100" : "opacity-0",
                      )}
                      name="check"
                    />
                    {!isString(option) && option.icon ? (
                      <Icon className="size-4" name={option.icon} />
                    ) : null}

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
