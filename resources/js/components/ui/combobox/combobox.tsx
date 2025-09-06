import * as React from "react";
import { Button } from "@narsil-cms/components/ui/button";
import { cn, getSelectOption } from "@narsil-cms/lib/utils";
import { Icon } from "@narsil-cms/components/ui/icon";
import { debounce, isArray, lowerCase } from "lodash";
import { useLabels } from "@narsil-cms/components/ui/labels";
import { useVirtualizer } from "@tanstack/react-virtual";
import ComboboxBadge from "./combobox-badge";
import ComboboxItem from "./combobox-item";
import {
  Command,
  CommandEmpty,
  CommandGroup,
  CommandInput,
  CommandList,
} from "@narsil-cms/components/ui/command";
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from "@narsil-cms/components/ui/popover";
import type { SelectOption } from "@narsil-cms/types/forms";

type ComboboxProps = {
  className?: string;
  disabled?: boolean;
  displayValue?: boolean;
  id?: string;
  labelPath?: string;
  multiple?: boolean;
  options: SelectOption[] | string[];
  placeholder?: string;
  searchable?: boolean;
  value: string | string[];
  valuePath?: string;
  renderOption?: (option: SelectOption | string) => React.ReactNode;
  setValue: (value: string | string[]) => void;
};

function Combobox({
  className,
  disabled,
  displayValue = true,
  id,
  labelPath = "label",
  multiple = false,
  placeholder,
  searchable = true,
  value,
  valuePath = "value",
  options,
  renderOption,
  setValue,
}: ComboboxProps) {
  const { trans } = useLabels();

  if (multiple && !isArray(value)) {
    value = [value];
  }

  const parentRef = React.useRef<HTMLDivElement | null>(null);

  const [open, setOpen] = React.useState(false);
  const [input, setInput] = React.useState("");
  const [search, setSearch] = React.useState("");

  const debouncedSetSearch = React.useMemo(
    () => debounce((value: string) => setSearch(value), 300),
    [],
  );

  function onValueChange(value: string) {
    setInput(value);
    debouncedSetSearch(value);
  }

  const filteredOptions = React.useMemo(() => {
    if (!search) {
      return options;
    }

    const searchedLabel = lowerCase(search);

    return options.filter((option) => {
      const optionLabel = getSelectOption(option, labelPath);

      return lowerCase(optionLabel).includes(searchedLabel);
    });
  }, [options, search]);

  const selectedValues = React.useMemo<string[]>(() => {
    return multiple ? (value as string[]) : value ? [value as string] : [];
  }, [value, multiple]);

  const selectedOptions = React.useMemo(() => {
    return options.filter((option) =>
      selectedValues.includes(getSelectOption(option, valuePath)),
    );
  }, [options, selectedValues, valuePath]);

  const option = options.find((option) => {
    const optionValue = getSelectOption(option, valuePath);

    return optionValue == value;
  });

  const optionIndex = React.useMemo(() => {
    if (!option) {
      return -1;
    }

    return filteredOptions.indexOf(option);
  }, [filteredOptions, option]);

  const virtualizer = useVirtualizer({
    count: filteredOptions.length,
    getScrollElement: () => parentRef.current,
    estimateSize: () => 36,
  });

  function onSelect(selectedValue: string) {
    if (multiple) {
      if (selectedValues.includes(selectedValue)) {
        setValue(selectedValues.filter((x) => x !== selectedValue));
      } else {
        setValue([...selectedValues, selectedValue]);
      }
    } else {
      setValue(selectedValue === value ? "" : selectedValue);
    }

    setOpen(false);
  }

  React.useEffect(() => {
    if (open) {
      requestAnimationFrame(() => {
        virtualizer.measure();

        requestAnimationFrame(() => {
          virtualizer.scrollToIndex(optionIndex, { align: "center" });
        });
      });
    }
  }, [open, optionIndex, virtualizer]);

  return (
    <Popover open={open} onOpenChange={setOpen} modal>
      <PopoverTrigger asChild>
        <Button
          id={id}
          className={cn(
            "bg-input/25 w-full justify-between font-normal",
            className,
          )}
          aria-expanded={open}
          disabled={disabled}
          role="combobox"
          variant="outline"
        >
          {selectedOptions.length > 0 ? (
            multiple ? (
              <div className="flex flex-wrap gap-1">
                {selectedOptions.map((option, index) => {
                  return (
                    <ComboboxBadge
                      item={option}
                      labelPath={labelPath}
                      value={value as string[]}
                      valuePath={valuePath}
                      setValue={setValue}
                      key={index}
                    />
                  );
                })}
              </div>
            ) : (
              getSelectOption(selectedOptions[0], labelPath)
            )
          ) : (
            (placeholder ?? trans("placeholders.search"))
          )}
          <Icon
            className={cn("ml-2 shrink-0 duration-300", open && "rotate-180")}
            name="chevron-down"
          />
        </Button>
      </PopoverTrigger>
      <PopoverContent className="p-0">
        <Command shouldFilter={false}>
          {searchable ? (
            <CommandInput
              value={input}
              onValueChange={onValueChange}
              placeholder={placeholder ?? trans("placeholders.search")}
            />
          ) : null}
          <CommandList ref={parentRef}>
            <CommandEmpty>{trans("pagination.empty")}</CommandEmpty>
            <CommandGroup>
              <div
                className="relative w-full"
                style={{
                  height: `${virtualizer.getTotalSize()}px`,
                }}
              >
                {virtualizer
                  .getVirtualItems()
                  .map(({ index, key, size, start }) => {
                    return (
                      <ComboboxItem
                        className={cn(
                          "absolute top-0 left-0 h-9 w-full will-change-transform",
                        )}
                        displayValue={displayValue}
                        item={filteredOptions[index]}
                        labelPath={labelPath}
                        value={value}
                        valuePath={valuePath}
                        onSelect={onSelect}
                        renderOption={renderOption}
                        style={{
                          height: `${size}px`,
                          transform: `translateY(${start}px)`,
                        }}
                        key={key}
                      />
                    );
                  })}
              </div>
            </CommandGroup>
          </CommandList>
        </Command>
      </PopoverContent>
    </Popover>
  );
}

export default Combobox;
