import { TextareaRoot } from "@narsil-cms/components/textarea";
import { type ComponentProps } from "react";

type TextareaProps = ComponentProps<typeof TextareaRoot>;

function Textarea({ ...props }: TextareaProps) {
  return <TextareaRoot {...props} />;
}

export default Textarea;
