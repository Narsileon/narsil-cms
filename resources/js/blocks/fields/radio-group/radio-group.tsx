import { FormLabel } from "@narsil-cms/components/form";
import {
  RadioGroupIndicator,
  RadioGroupItem,
  RadioGroupRoot,
} from "@narsil-cms/components/radio-group";
import { get, isString } from "lodash-es";
import { type ComponentProps } from "react";

type RadioGroupOption =
  | string
  | {
      label: string;
      value: string;
    };

type RadioGroupProps = ComponentProps<typeof RadioGroupRoot> & {
  options?: RadioGroupOption[];
};

function RadioGroup({ options, ...props }: RadioGroupProps) {
  function getOptionLabel(option: RadioGroupOption) {
    if (isString(option)) {
      return option;
    }

    return get(option, "label");
  }

  function getOptionValue(option: RadioGroupOption) {
    if (isString(option)) {
      return option;
    }

    return get(option, "value");
  }

  return (
    <RadioGroupRoot {...props}>
      {options?.map((option, index) => {
        const id = `r${index}`;

        const optionLabel = getOptionLabel(option);
        const optionValue = getOptionValue(option);

        return (
          <div className="flex items-center gap-3" key={id}>
            <RadioGroupItem value={optionValue} id={id}>
              <RadioGroupIndicator />
            </RadioGroupItem>
            <FormLabel htmlFor={id}>{optionLabel}</FormLabel>
          </div>
        );
      })}
    </RadioGroupRoot>
  );
}

export default RadioGroup;
