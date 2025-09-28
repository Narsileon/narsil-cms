import { type VariantProps } from "class-variance-authority";
import { type ComponentProps } from "react";

import { Border } from "@narsil-cms/components/border";
import { cn } from "@narsil-cms/lib/utils";

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
      <Border className="hidden group-focus-within/input:block" />
    </>
  );
}

export default InputContent;
