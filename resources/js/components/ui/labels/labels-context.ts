import { createContext, useContext } from "react";

export type LabelsContextProps = {
  getLabel: (key: string, fallback?: string) => string;
};

export const LabelsContext = createContext<LabelsContextProps>({
  getLabel: () => "string",
});

function useLabels() {
  const context = useContext(LabelsContext);

  if (!context) {
    throw new Error("useLabels must be used within a LabelsProvider");
  }

  return context;
}

export default useLabels;
