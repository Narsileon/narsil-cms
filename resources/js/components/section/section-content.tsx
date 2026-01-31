import { type ComponentProps } from "react";

function SectionContent({ ...props }: ComponentProps<"div">) {
  return <div data-slot="section-content" {...props} />;
}

export default SectionContent;
