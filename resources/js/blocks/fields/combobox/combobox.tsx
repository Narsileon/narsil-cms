import { router } from "@inertiajs/react";
import { Badge, Tooltip } from "@narsil-cms/blocks";
import {
  CommandEmpty,
  CommandGroup,
  CommandInput,
  CommandItem,
  CommandList,
  CommandRoot,
} from "@narsil-cms/components/command";
import CommandInputWrapper from "@narsil-cms/components/command/command-input-wrapper";
import { Icon } from "@narsil-cms/components/icon";
import { InputRoot } from "@narsil-cms/components/input";
import { useLocalization } from "@narsil-cms/components/localization";
import {
  PopoverContent,
  PopoverPortal,
  PopoverRoot,
  PopoverTrigger,
} from "@narsil-cms/components/popover";
import { useLocale } from "@narsil-cms/hooks/use-props";
import { cn, getSelectOption, getTranslatableSelectOption } from "@narsil-cms/lib/utils";
import type { SelectOption } from "@narsil-cms/types";
import { useVirtualizer } from "@tanstack/react-virtual";
import parse from "html-react-parser";
import { debounce, isArray, isNumber, isString, lowerCase } from "lodash";
import { useEffect, useMemo, useRef, useState } from "react";

type ComboboxProps = {
  className?: string;
  clearable?: boolean;
  collection?: string;
  disabled?: boolean;
  displayValue?: boolean;
  id: string;
  labelPath?: string;
  multiple?: boolean;
  options: SelectOption[] | string[];
  placeholder?: string;
  reload?: string;
  searchable?: boolean;
  value: string | string[];
  valuePath?: string;
  setValue: (value: string | string[]) => void;
};

function Combobox({
  className,
  clearable = false,
  disabled,
  displayValue = true,
  id,
  labelPath = "label",
  multiple = false,
  options,
  placeholder,
  reload,
  searchable = true,
  value,
  valuePath = "value",
  setValue,
}: ComboboxProps) {
  const { locale } = useLocale();
  const { trans } = useLocalization();

  if (multiple && !isArray(value)) {
    value = value ? [value] : [];
  } else if (isNumber(value)) {
    value = value.toString();
  }

  const parentRef = useRef<HTMLDivElement | null>(null);

  const [loading, setLoading] = useState<boolean>(false);
  const [open, setOpen] = useState<boolean>(false);
  const [input, setInput] = useState<string>("");
  const [search, setSearch] = useState<string>("");

  const debouncedSetSearch = useMemo(() => debounce((value: string) => setSearch(value), 300), []);

  function onValueChange(value: string) {
    setInput(value);
    debouncedSetSearch(value);
  }

  const filteredOptions = useMemo(() => {
    if (!search) {
      return options;
    }

    const searchedLabel = lowerCase(search);

    return options.filter((option) => {
      const optionLabel = getTranslatableSelectOption(option, labelPath, locale);

      return lowerCase(optionLabel).includes(searchedLabel);
    });
  }, [options, search]);

  const selectedValues = useMemo<string[]>(() => {
    return multiple ? (value as string[]) : value ? [value as string] : [];
  }, [value, multiple]);

  const selectedOptions = useMemo(() => {
    return options.filter((option) => selectedValues.includes(getSelectOption(option, valuePath)));
  }, [options, selectedValues, valuePath]);

  const option = options.find((option) => {
    const optionValue = getSelectOption(option, valuePath);

    return optionValue == value;
  });

  const optionIndex = useMemo(() => {
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
      if (selectedValue === value) {
        if (!clearable) {
          setOpen(false);

          return;
        }
        setValue("");
      } else {
        setValue(selectedValue);
      }
    }

    if (reload) {
      router.reload({ data: { [id]: selectedValue }, only: [reload] });
    }

    setOpen(false);
  }

  useEffect(() => {
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
    <PopoverRoot open={open} onOpenChange={setOpen} modal>
      <PopoverTrigger asChild>
        <InputRoot
          id={id}
          className={cn("data-[state=open]:border-shine", className)}
          aria-expanded={open}
          aria-disabled={disabled}
          role="combobox"
          variant="button"
        >
          {selectedOptions.length > 0 ? (
            multiple ? (
              <div className="-ml-1 flex flex-wrap gap-1">
                {selectedOptions.map((option, index) => {
                  const optionLabel = getTranslatableSelectOption(option, labelPath, locale);
                  const optionValue = getSelectOption(option, valuePath);

                  return (
                    <Badge
                      onClose={() => setValue((value as string[]).filter((x) => x !== optionValue))}
                      key={index}
                    >
                      {optionLabel}
                    </Badge>
                  );
                })}
              </div>
            ) : (
              parse(getTranslatableSelectOption(selectedOptions[0], labelPath, locale))
            )
          ) : (
            (placeholder ?? trans("placeholders.search"))
          )}
          {clearable && value ? (
            <Icon
              className={cn("ml-2 shrink-0")}
              name="x"
              onClick={() => {
                setValue("");
              }}
            />
          ) : (
            <Icon
              className={cn("ml-2 shrink-0 duration-300", open && "rotate-180")}
              name="chevron-down"
            />
          )}
        </InputRoot>
      </PopoverTrigger>
      <PopoverPortal>
        <PopoverContent className="p-0">
          <CommandRoot shouldFilter={false}>
            {searchable ? (
              <CommandInputWrapper>
                <Icon className="size-4 shrink-0 opacity-50" name="search" />
                <CommandInput
                  value={input}
                  onValueChange={onValueChange}
                  placeholder={placeholder ?? trans("placeholders.search")}
                />
              </CommandInputWrapper>
            ) : null}
            <CommandList ref={parentRef}>
              <CommandEmpty>
                {loading ? trans("ui.loading") : trans("pagination.pages_empty")}
              </CommandEmpty>
              <CommandGroup>
                <div
                  className="relative w-full"
                  style={{
                    height: `${virtualizer.getTotalSize()}px`,
                  }}
                >
                  {virtualizer.getVirtualItems().map(({ index, key, size, start }) => {
                    const option = filteredOptions[index];

                    const optionLabel = getTranslatableSelectOption(option, labelPath, locale);
                    const optionValue = getSelectOption(option, valuePath);

                    const isSelected = Array.isArray(value)
                      ? value.includes(optionValue)
                      : value === optionValue;

                    return (
                      <CommandItem
                        className={cn("absolute top-0 left-0 h-9 w-full will-change-transform")}
                        value={optionValue.toString()}
                        onSelect={onSelect}
                        style={{
                          height: `${size}px`,
                          transform: `translateY(${start}px)`,
                        }}
                        key={key}
                      >
                        <Icon
                          className={cn("size-4", isSelected ? "opacity-100" : "opacity-0")}
                          name="check"
                        />
                        {!isString(option) && option.icon ? (
                          <Icon className="size-4" name={option.icon} />
                        ) : null}
                        <div className="flex w-full items-center justify-between gap-2 truncate">
                          <div className="min-w-1/2 grow truncate">{parse(optionLabel)}</div>
                          {displayValue && (
                            <Tooltip tooltip={optionValue}>
                              <span className="truncate text-muted-foreground">{optionValue}</span>
                            </Tooltip>
                          )}
                        </div>
                      </CommandItem>
                    );
                  })}
                </div>
              </CommandGroup>
            </CommandList>
          </CommandRoot>
        </PopoverContent>
      </PopoverPortal>
    </PopoverRoot>
  );
}

export default Combobox;
