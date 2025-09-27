import { type VariantProps } from "class-variance-authority";
import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

import { InputBorder } from "./input-border";
import inputContentVariants from "./input-content-variants";

type InputContentProps = ComponentProps<"input"> &
  VariantProps<typeof inputContentVariants> & {};

const TYPES = {
  date: "date",
  file: "file",
  image: "image",
  number: "number",
} as const;

function InputContent({
  className,
  type,
  variant,
  ...props
}: InputContentProps) {
  function getVariant() {
    if (variant) {
      return variant;
    }

    if (type && type in TYPES) {
      return TYPES[type as keyof typeof TYPES];
    }

    return "default";
  }

  return (
    <>
      <input
        data-slot="input-content"
        className={cn(
          inputContentVariants({
            className: className,
            variant: getVariant(),
          }),
        )}
        type={type}
        {...props}
      />
      <InputBorder className="hidden group-focus-within:block" />
    </>
  );
}

export default InputContent;
