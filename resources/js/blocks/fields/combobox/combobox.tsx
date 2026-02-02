import { router } from "@inertiajs/react";
import { Button } from "@narsil-cms/components/button";
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
} from "@narsil-cms/components/combobox";
import ComboboxClear from "@narsil-cms/components/combobox/combobox-clear";
import { InputGroup, InputGroupAddon, InputGroupInput } from "@narsil-cms/components/input-group";
import { useLocalization } from "@narsil-cms/components/localization";
import { useLocale } from "@narsil-cms/hooks/use-props";
import { getSelectOption, getTranslatableSelectOption } from "@narsil-cms/lib/utils";
import type { SelectOption } from "@narsil-cms/types";
import { useVirtualizer } from "@tanstack/react-virtual";
import parse from "html-react-parser";
import { debounce, isArray, isNumber, lowerCase } from "lodash-es";
import { useCallback, useEffect, useMemo, useRef, useState } from "react";

type ComboboxProps = {
  className?: string;
  clearable?: boolean;
  collection?: string;
  disabled?: boolean;
  displayValue?: boolean;
  extraQuery?: Record<string, unknown>;
  href?: string;
  id: string;
  labelPath?: string;
  multiple?: boolean;
  options: SelectOption[] | string[];
  placeholder?: string;
  reload?: string;
  route?: string;
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
  extraQuery,
  href,
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
  const { trans } = useLocalization();

  if (multiple && !isArray(value)) {
    value = value ? [value] : [];
  } else if (isNumber(value)) {
    value = value.toString();
  }

  const scrollElementRef = useRef<HTMLDivElement>(null);

  const [fetchedOptions, setFetchedOptions] = useState<SelectOption[]>([]);
  const [loading, setLoading] = useState<boolean>(false);
  const [open, setOpen] = useState<boolean>(false);
  const [input, setInput] = useState<string>("");
  const [searchValue, setSearchValue] = useState<string>("");

  const resolvedOptions = href ? fetchedOptions : options;

  const debouncedSetFetchedOptions = useMemo(
    () =>
      debounce(async (query: string) => {
        if (!href || query.length < 3) {
          return;
        }

        setLoading(true);

        try {
          const url = new URL(href, window.location.origin);

          url.searchParams.set("search", query);

          if (extraQuery) {
            Object.entries(extraQuery).forEach(([key, value]) => {
              if (Array.isArray(value)) {
                value.forEach((item) => {
                  url.searchParams.append(`${key}[]`, String(item));
                });
              } else {
                url.searchParams.set(key, String(value));
              }
            });
          }

          const response = await fetch(url.toString());

          if (!response.ok) {
            throw new Error("Failed to fetch options");
          }

          const data = await response.json();

          setFetchedOptions(data);
        } catch (error) {
          console.error(error);
        } finally {
          setLoading(false);
        }
      }, 400),
    [href],
  );

  const debouncedSetSearch = useMemo(
    () => debounce((value: string) => setSearchValue(value), 300),
    [],
  );
  function onValueChange(value: string) {
    setInput(value);
    debouncedSetSearch(value);

    if (href && value.length >= 3) {
      debouncedSetFetchedOptions(value);
    }
  }

  const filteredItems = useMemo(() => {
    if (href) {
      return resolvedOptions;
    }

    if (!searchValue) {
      return resolvedOptions;
    }

    const searchedLabel = lowerCase(searchValue);

    return resolvedOptions.filter((option) => {
      const optionLabel = getTranslatableSelectOption(option, labelPath, locale);

      return lowerCase(optionLabel).includes(searchedLabel);
    });
  }, [locale, href, resolvedOptions, searchValue]);

  const selectedValues = useMemo<string[]>(() => {
    return multiple ? (value as string[]) : value ? [value as string] : [];
  }, [value, multiple]);

  const selectedOptions = useMemo(() => {
    return resolvedOptions.filter((option) =>
      selectedValues.includes(getSelectOption(option, valuePath)),
    );
  }, [resolvedOptions, selectedValues, valuePath]);

  const option = resolvedOptions.find((option) => {
    const optionValue = getSelectOption(option, valuePath);

    return optionValue == value;
  });

  const optionIndex = useMemo(() => {
    if (!option) {
      return -1;
    }

    return filteredItems.indexOf(option);
  }, [filteredItems, option]);

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
    return () => {
      debouncedSetFetchedOptions.cancel();
      debouncedSetSearch.cancel();
    };
  }, []);

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
      open={open}
      onOpenChange={setOpen}
      itemToStringLabel={(item) => getTranslatableSelectOption(item, labelPath, locale)}
      itemtoStringValue={(item) => getSelectOption(item, valuePath)}
      onInputValueChange={setSearchValue}
      onValueChange={onValueChange}
      value={value}
      virtualized={true}
    >
      <ComboboxTrigger
        render={
          <Button variant="outline" className="justify-between font-normal">
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
            <ComboboxEmpty>
              {loading ? trans("ui.loading") : trans("pagination.pages_empty")}
            </ComboboxEmpty>
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
