import { router } from "@inertiajs/react";
import { useLocale } from "@narsil-cms/hooks/use-props";
import { getSelectOption, getTranslatableSelectOption } from "@narsil-cms/lib/utils";
import type { SelectOption } from "@narsil-cms/types";
import { Button } from "@narsil-ui/components/button";
import {
  ComboboxEmpty,
  ComboboxInput,
  ComboboxItem,
  ComboboxList,
  ComboboxPopup,
  ComboboxPortal,
  ComboboxPositioner,
  ComboboxRoot,
  ComboboxTrigger,
  ComboboxValue,
} from "@narsil-ui/components/combobox";
import ComboboxClear from "@narsil-ui/components/combobox/combobox-clear";
import { InputGroup, InputGroupAddon, InputGroupInput } from "@narsil-ui/components/input-group";
import { useTranslator } from "@narsil-ui/components/translator";
import { cn } from "@narsil-ui/lib/utils";
import { useVirtualizer } from "@tanstack/react-virtual";
import parse from "html-react-parser";
import { isArray, isNumber, lowerCase } from "lodash-es";
import { useCallback, useMemo, useRef, useState } from "react";

type ComboboxProps = {
  className?: string;
  clearable?: boolean;
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
  options = [],
  placeholder,
  reload,
  searchable = true,
  value,
  valuePath = "value",
  setValue,
}: ComboboxProps) {
  const { locale } = useLocale();
  const { trans } = useTranslator();

  if (multiple && !isArray(value)) {
    value = value ? [value] : [];
  } else if (isNumber(value)) {
    value = value.toString();
  }

  const scrollElementRef = useRef<HTMLDivElement>(null);

  const [open, setOpen] = useState<boolean>(false);
  const [searchValue, setSearchValue] = useState<string>("");

  const filteredItems = useMemo(() => {
    if (!searchValue) {
      return options;
    }

    const searchedLabel = lowerCase(searchValue);

    return options.filter((option) => {
      const optionLabel = getTranslatableSelectOption(option, labelPath, locale);

      return lowerCase(optionLabel).includes(searchedLabel);
    });
  }, [locale, options, searchValue]);

  const selectedValues = useMemo<string[]>(() => {
    return multiple ? (value as string[]) : value ? [value as string] : [];
  }, [value, multiple]);

  const selectedOptions = useMemo(() => {
    return options.filter((option) => selectedValues.includes(getSelectOption(option, valuePath)));
  }, [options, selectedValues, valuePath]);

  const virtualizer = useVirtualizer({
    count: filteredItems.length,
    enabled: open,
    overscan: 20,
    paddingEnd: 8,
    paddingStart: 8,
    scrollPaddingEnd: 8,
    scrollPaddingStart: 8,
    estimateSize: () => 32,
    getScrollElement: () => scrollElementRef.current,
  });

  function onSelect(selectedValue: string) {
    if (!selectedValue) {
      return;
    }

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

  const handleScrollElementRef = useCallback(
    (element: HTMLDivElement | null) => {
      scrollElementRef.current = element;
      if (element) {
        virtualizer.measure();
      }
    },
    [virtualizer],
  );

  const totalSize = virtualizer.getTotalSize();

  return (
    <ComboboxRoot
      filteredItems={filteredItems}
      inputValue={searchValue}
      items={options}
      itemToStringLabel={(item) =>
        getTranslatableSelectOption(item as SelectOption, labelPath, locale)
      }
      itemToStringValue={(item) => getSelectOption(item as SelectOption, valuePath)}
      onInputValueChange={setSearchValue}
      onOpenChange={setOpen}
      open={open}
      onValueChange={(value) => {
        onSelect(value as string);
      }}
      value={value}
      virtualized={true}
    >
      <ComboboxTrigger
        render={
          <Button variant="outline" className={cn("w-full justify-between font-normal", className)}>
            <ComboboxValue />
          </Button>
        }
      />
      <ComboboxPortal>
        <ComboboxPositioner>
          <ComboboxPopup>
            {searchable && (
              <InputGroup>
                <ComboboxInput
                  placeholder={placeholder ?? trans("placeholders.search")}
                  render={<InputGroupInput disabled={disabled} />}
                />
                <InputGroupAddon align="inline-end">
                  {clearable && <ComboboxClear disabled={disabled} />}
                </InputGroupAddon>
              </InputGroup>
            )}
            <ComboboxEmpty>{trans("pagination.pages_empty")}</ComboboxEmpty>
            <ComboboxList
              ref={handleScrollElementRef}
              role="presentation"
              className="h-[min(22rem,var(--total-size))] max-h-(--available-height) overflow-auto overscroll-contain"
              style={{ "--total-size": `${totalSize}px` } as React.CSSProperties}
            >
              {filteredItems.length > 0 && (
                <div role="presentation" className="relative w-full" style={{ height: totalSize }}>
                  {virtualizer.getVirtualItems().map((virtualItem) => {
                    const item = filteredItems[virtualItem.index];

                    if (!item) {
                      return null;
                    }

                    const optionLabel = getTranslatableSelectOption(item, labelPath, locale);
                    const optionValue = getSelectOption(item, valuePath);

                    return (
                      <ComboboxItem
                        ref={virtualizer.measureElement}
                        index={virtualItem.index}
                        data-index={virtualItem.index}
                        value={optionValue}
                        aria-setsize={filteredItems.length}
                        aria-posinset={virtualItem.index + 1}
                        style={{
                          position: "absolute",
                          top: 0,
                          left: 0,
                          width: "100%",
                          height: virtualItem.size,
                          transform: `translateY(${virtualItem.start}px)`,
                        }}
                        key={virtualItem.key}
                      >
                        {parse(optionLabel)}
                      </ComboboxItem>
                    );
                  })}
                </div>
              )}
            </ComboboxList>
          </ComboboxPopup>
        </ComboboxPositioner>
      </ComboboxPortal>
    </ComboboxRoot>
  );
}

export default Combobox;
