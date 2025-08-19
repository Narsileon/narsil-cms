import * as React from "react";
import { Button } from "@narsil-cms/components/ui/button";
import { cn, getSelectOption } from "@narsil-cms/lib/utils";
import { Icon } from "@narsil-cms/components/ui/icon";
import { debounce, lowerCase } from "lodash";
import { useLabels } from "@narsil-cms/components/ui/labels";
import { useVirtualizer } from "@tanstack/react-virtual";
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
import type { UniqueIdentifier } from "@dnd-kit/core";

type ComboboxProps = {
  className?: string;
  disabled?: boolean;
  displayValue?: boolean;
  id?: string;
  labelPath?: string;
  options: SelectOption[] | string[];
  placeholder?: string;
  searchable?: boolean;
  value: UniqueIdentifier;
  valuePath?: string;
  renderOption?: (option: SelectOption | string) => React.ReactNode;
  setValue: (value: string) => void;
};

function Combobox({
  className,
  disabled,
  displayValue = true,
  id,
  labelPath = "label",
  placeholder,
  searchable = true,
  value,
  valuePath = "value",
  options,
  renderOption,
  setValue,
}: ComboboxProps) {
  const { getLabel } = useLabels();

  const parentRef = React.useRef<HTMLDivElement | null>(null);

  const [open, setOpen] = React.useState(false);
  const [search, setSearch] = React.useState("");

  const debouncedSetSearch = React.useMemo(
    () => debounce((value: string) => setSearch(value), 300),
    [],
  );

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
      <PopoverContent className="p-0">
        <Command shouldFilter={false}>
          {searchable ? (
            <CommandInput
              onValueChange={debouncedSetSearch}
              placeholder={placeholder ?? getLabel("placeholders.search")}
            />
          ) : null}
          <CommandList ref={parentRef}>
            <CommandEmpty>{getLabel("pagination.empty")}</CommandEmpty>
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
                        className={cn("absolute top-0 left-0 h-9 w-full")}
                        displayValue={displayValue}
                        item={filteredOptions[index]}
                        labelPath={labelPath}
                        value={value as string}
                        valuePath={valuePath}
                        onSelect={(currentValue) => {
                          setValue(currentValue == value ? "" : currentValue);
                          setOpen(false);
                        }}
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
